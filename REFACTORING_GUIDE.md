# Refactoring Guide: Using Business Logic Classes with Livewire

## Overview

Yes, you can absolutely use your business logic classes (`SudokuBL`, `SudokuBoard`, etc.) with Livewire components! This provides better separation of concerns, testability, and maintainability.

## Architecture Benefits

1. **Separation of Concerns**: Business logic stays in classes, presentation in Livewire
2. **Testability**: Business logic can be tested independently
3. **Reusability**: Business logic can be used by controllers, jobs, commands, etc.
4. **Single Source of Truth**: Game state managed in one place

## Step 1: Create Persistence Layer (if not exists)

First, you need to create the persistence interface and implementation:

```php
// app/Classes/Persistence/PersistenceInterface.php
<?php

namespace App\Classes\Persistence;

use App\Classes\SudokuDTO;

interface PersistenceInterface
{
    public function loadGame(): ?SudokuDTO;
    public function saveGame(SudokuDTO $data): void;
    public function resetGame(): SudokuDTO;
}
```

```php
// app/Classes/Persistence/PersistenceSession.php
<?php

namespace App\Classes\Persistence;

use App\Classes\SudokuDTO;

class PersistenceSession implements PersistenceInterface
{
    private const SESSION_KEY = 'sudoku_game';

    public function loadGame(): ?SudokuDTO
    {
        $data = session()->get(self::SESSION_KEY);
        return $data ? unserialize($data) : null;
    }

    public function saveGame(SudokuDTO $data): void
    {
        session()->put(self::SESSION_KEY, serialize($data));
    }

    public function resetGame(): SudokuDTO
    {
        $data = new SudokuDTO();
        $this->saveGame($data);
        return $data;
    }
}
```

## Step 2: Bind in Service Provider

```php
// app/Providers/AppServiceProvider.php
<?php

namespace App\Providers;

use App\Classes\SudokuBL;
use App\Classes\Persistence\PersistenceInterface;
use App\Classes\Persistence\PersistenceSession;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind persistence interface
        $this->app->singleton(PersistenceInterface::class, PersistenceSession::class);
        
        // Bind SudokuBL as singleton (shares state across requests)
        $this->app->singleton(SudokuBL::class, function ($app) {
            return new SudokuBL($app->make(PersistenceInterface::class));
        });
    }
}
```

## Step 3: Refactor Livewire Components

### Example: Refactored SudokuBoard Component

```php
// app/Livewire/SudokuBoard.php
<?php

namespace App\Livewire;

use App\Classes\SudokuBL;
use App\Classes\SudokuCell;
use Livewire\Component;

class SudokuBoard extends Component
{
    public SudokuBL $game;
    
    // Computed property that gets cells from business logic
    public function getCellsProperty(): array
    {
        return $this->game->getBoard()->getAllCells();
    }
    
    public function mount(SudokuBL $game)
    {
        $this->game = $game;
    }

    public function render()
    {
        return view('livewire.sudoku-board', [
            'cells' => $this->cells,
            'gameStatus' => $this->game->getStatus(),
        ]);
    }
}
```

### Example: Refactored SingleCell Component

```php
// app/Livewire/SingleCell.php
<?php

namespace App\Livewire;

use App\Classes\SudokuBL;
use App\Classes\SudokuCell;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class SingleCell extends Component
{
    public SudokuBL $game;
    public string $coord; // e.g., "A-1"
    
    public bool $edit = false;
    public bool $disabled = true;
    public bool $settingMode = false;
    
    public function mount(SudokuBL $game, string $coord)
    {
        $this->game = $game;
        $this->coord = $coord;
        $this->updateDisabledState();
    }
    
    #[Computed]
    public function cell(): ?SudokuCell
    {
        [$x, $y] = explode('-', $this->coord);
        return $this->game->getBoard()->findCell($x, $y);
    }
    
    #[Computed]
    public function value(): ?int
    {
        return $this->cell()?->value;
    }
    
    #[Computed]
    public function possibilities(): array
    {
        return $this->cell()?->possibilities ?? [];
    }
    
    #[Computed]
    public function showPossibilities(): bool
    {
        return count($this->possibilities) > 0;
    }
    
    public function selectCell()
    {
        if (!$this->disabled) {
            $this->edit = true;
            $this->dispatch('cell_selected', 
                cell: $this->coord,
                cellValue: $this->value,
                possibilities: $this->possibilities
            );
        }
    }
    
    #[On('set_cell_values')]
    public function setCellValues(string $cell, array $values, bool $showPossibilities)
    {
        if ($cell !== $this->coord) {
            return;
        }
        
        [$x, $y] = explode('-', $cell);
        
        if ($showPossibilities) {
            // Toggle possibilities
            foreach ($values as $value) {
                $this->game->setCellValue($x, $y, (int)$value, true);
            }
        } else {
            // Set cell value
            $value = count($values) > 0 ? (int)$values[0] : null;
            $this->game->setCellValue($x, $y, $value, false);
        }
        
        $this->edit = false;
    }
    
    #[On('set_gaming_state')]
    public function setGamingState(string $state)
    {
        $this->game->setStatus($state);
        $this->updateDisabledState();
    }
    
    private function updateDisabledState(): void
    {
        $status = $this->game->getStatus();
        $this->disabled = in_array($status, ['beginning', 'end']);
        $this->settingMode = $status === 'setup';
    }
    
    public function render()
    {
        return view('livewire.single-cell');
    }
}
```

### Example: Refactored SetupBoard Component

```php
// app/Livewire/SetupBoard.php
<?php

namespace App\Livewire;

use App\Classes\SudokuBL;
use App\Classes\SudokuDTO;
use Livewire\Component;
use Livewire\Attributes\Computed;

class SetupBoard extends Component
{
    public SudokuBL $game;
    
    public function mount(SudokuBL $game)
    {
        $this->game = $game;
    }
    
    #[Computed]
    public function currentState(): string
    {
        return $this->game->getStatus();
    }
    
    public function setup()
    {
        $this->game->setStatus(SudokuDTO::SETUP_STATE);
        $this->dispatch('set_gaming_state', state: SudokuDTO::SETUP_STATE);
    }
    
    public function play()
    {
        $this->game->setStatus(SudokuDTO::PLAYING_STATE);
        $this->dispatch('set_gaming_state', state: SudokuDTO::PLAYING_STATE);
    }
    
    public function pause()
    {
        $state = $this->currentState === SudokuDTO::PAUSED_STATE 
            ? SudokuDTO::PLAYING_STATE 
            : SudokuDTO::PAUSED_STATE;
            
        $this->game->setStatus($state);
        $this->dispatch('set_gaming_state', state: $state);
    }
    
    public function resetGame()
    {
        $this->game->reset();
        $this->game->setStatus(SudokuDTO::BEGINNING_STATE);
        $this->dispatch('set_gaming_state', state: SudokuDTO::BEGINNING_STATE);
    }
    
    #[Computed]
    public function pauseButtonText(): string
    {
        return $this->currentState === SudokuDTO::PAUSED_STATE ? "Restart" : "Pause";
    }
    
    public function render()
    {
        return view('livewire.setup-board');
    }
}
```

## Step 4: Update Blade Views

Your views can access the game state directly:

```blade
{{-- resources/views/livewire/sudoku-board.blade.php --}}
<div class="sudoku-board">
    @foreach($cells as $cell)
        <livewire:single-cell 
            :game="$game" 
            :coord="$cell->xCoordinate . '-' . $cell->yCoordinate" 
            :key="$cell->xCoordinate . $cell->yCoordinate"
        />
    @endforeach
</div>
```

## Key Points

1. **Dependency Injection**: Livewire components can receive dependencies via `mount()` method
2. **Computed Properties**: Use `#[Computed]` for derived data that updates reactively
3. **State Management**: Business logic handles all state; Livewire just displays it
4. **Events**: Still use Livewire events for component communication
5. **Reactivity**: When you call `$this->game->setCellValue()`, the state updates automatically

## Migration Strategy

1. Start with one component (e.g., `SetupBoard`)
2. Inject `SudokuBL` via `mount()`
3. Replace local state with calls to `$this->game`
4. Test thoroughly
5. Move to next component

This approach keeps your business logic clean and testable while leveraging Livewire's reactivity!

