# Sudoku Implementation Structure

This document describes the directory structure and organization of the dual implementation approach for the Sudoku game dashboard.

## Overview

The project supports two distinct implementations that can be switched via configuration:

- **Livewire Components** - Full-stack reactive components using Laravel Livewire
- **MVC + Alpine.js** - Traditional controller-based architecture with Alpine.js for frontend reactivity

Both implementations share the same business logic layer, ensuring consistency and maintainability.

## Directory Structure

```
app/
├── Classes/                    # Shared business logic (used by both implementations)
│   ├── SudokuBL.php           # Main game business logic
│   ├── SudokuBoard.php        # Board management
│   ├── SudokuCell.php         # Cell model
│   ├── SudokuDTO.php          # Data transfer object
│   └── Persistence/           # Persistence layer
│       ├── PersistenceInterface.php
│       ├── PersistenceSession.php
│       └── PersistenceFake.php
│
├── Http/
│   └── Controllers/           # MVC implementation controllers
│       └── DashboardController.php
│
├── Livewire/                   # Livewire implementation components
│   ├── SudokuBoard.php
│   ├── SingleCell.php
│   ├── SelectNumber.php
│   ├── SetupBoard.php
│   └── FlashMessage.php
│
└── View/
    └── Components/            # MVC implementation Blade components
        ├── SudokuBoard.php
        ├── SingleCell.php
        ├── SelectNumber.php
        └── SetupBoard.php

resources/views/
├── livewire/                  # Livewire component views
│   ├── sudoku-board.blade.php
│   ├── single-cell.blade.php
│   ├── select-number.blade.php
│   └── setup-board.blade.php
│
├── controllers/               # MVC component views
│   ├── sudoku-board.blade.php
│   ├── single-cell.blade.php
│   ├── select-number.blade.php
│   └── setup-board.blade.php
│
└── dashboard.blade.php        # Main dashboard (switches between implementations)

routes/
├── web.php                    # Main route file (conditionally loads implementation routes)
├── livewire.php              # Livewire-specific routes
└── controllers.php            # MVC + Alpine.js API routes

config/
└── sudoku.php                # Implementation configuration
```

## Configuration

The active implementation is controlled via the `config/sudoku.php` file:

```php
'implementation' => env('SUDOKU_IMPLEMENTATION', 'controllers'),
```

You can set this in your `.env` file:

```env
SUDOKU_IMPLEMENTATION=livewire
# or
SUDOKU_IMPLEMENTATION=controllers
```

## Shared Business Logic

Both implementations use the same business logic layer located in `app/Classes/`:

- **SudokuBL** - Main game business logic, handles all game operations
- **SudokuBoard** - Board management and cell retrieval
- **SudokuCell** - Individual cell model with value and possibilities
- **SudokuDTO** - Data transfer object for game state
- **PersistenceInterface** - Abstraction for game state persistence

This ensures that:
- Game rules and logic are consistent across implementations
- Bug fixes and improvements benefit both implementations
- Business logic can be tested independently

## Implementation Details

### Livewire Implementation

**Components:**
- `SudokuBoard` - Renders the 9x9 grid of cells
- `SingleCell` - Individual cell component with reactive properties
- `SelectNumber` - Number selection interface
- `SetupBoard` - Game state control buttons

**Features:**
- Full-stack reactivity without writing JavaScript
- Server-side state management
- Automatic DOM updates via Livewire's reactivity system

### MVC + Alpine.js Implementation

**Controllers:**
- `DashboardController` - Handles all AJAX requests for game operations

**Components:**
- Blade components in `app/View/Components/` for UI structure
- Alpine.js for client-side reactivity
- AJAX requests to controller endpoints

**Features:**
- Traditional MVC architecture
- Client-side reactivity with Alpine.js
- Explicit API endpoints for all operations

## Switching Implementations

To switch between implementations:

1. **Via Environment Variable** (recommended):
   ```env
   SUDOKU_IMPLEMENTATION=livewire
   ```

2. **Via Config File**:
   Edit `config/sudoku.php`:
   ```php
   'implementation' => 'livewire',
   ```

3. **Clear Config Cache** (if needed):
   ```bash
   php artisan config:clear
   ```

## Helper Functions

The `app/helpers.php` file provides utility functions:

- `sudoku_implementation()` - Get current implementation
- `is_livewire_implementation()` - Check if Livewire is active
- `is_controllers_implementation()` - Check if MVC is active
- `getCellCoords($cell)` - Extract coordinates from cell data
- `getCellValue($cell)` - Extract value/possibilities from cell data

## Route Organization

Routes are conditionally loaded in `routes/web.php` based on the active implementation:

- **Livewire**: Routes are minimal as Livewire handles most routing internally
- **MVC**: Full API routes for all game operations (`/start-game`, `/set-status`, etc.)

## Best Practices

1. **Business Logic**: Always add new game features to `app/Classes/` so both implementations benefit
2. **Views**: Keep views separate in their respective directories
3. **Testing**: Test both implementations when adding new features
4. **Documentation**: Update this file when making structural changes

## Future Considerations

This structure makes it easy to:
- Add new implementations (e.g., Vue.js SPA)
- Compare performance and user experience
- Maintain both implementations with shared business logic
- Migrate from one implementation to another gradually
