Sudoku Platform using Laravel and Livewire

## Implementation Approaches

This project explores different architectural approaches for building a reactive Sudoku game dashboard. Two distinct implementations have been developed:

- **Livewire Components** - Full-stack reactive components using Laravel Livewire
- **Classic MVC with Alpine.js** - Traditional controller-based architecture with Alpine.js for frontend reactivity

Both implementations coexist in the same codebase and can be switched via configuration, allowing for direct comparison while sharing the same business logic layer.

## Project Goals

The primary objective was to evaluate how Livewire performs when handling real-time, interactive game mechanics. Through this experimentation, I discovered that the Classic MVC + Alpine.js approach provided superior visual reactivity and overall user experience for this particular use case.

While Alpine.js excels as a lightweight, progressive enhancement library, it can present challenges when implementing more complex, feature-rich interactions.

## Project Structure

The project is organized to support multiple implementations while sharing business logic:

- **Shared Business Logic** (`app/Classes/`) - Used by all implementations
- **Livewire Components** (`app/Livewire/`) - Full-stack reactive components
- **MVC Controllers** (`app/Http/Controllers/`) - Controller-based API with Alpine.js for frontend reactivity
- **View Components** - Separate views for each implementation in `resources/views/`

See [IMPLEMENTATION_STRUCTURE.md](IMPLEMENTATION_STRUCTURE.md) for detailed documentation.

## Installation

This application does **not require a database**. All game state is stored in session files.

### Setup Steps

1. **Copy environment file:**
   ```bash
   cp .env.example .env
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Generate application key:**
   ```bash
   php artisan key:generate
   ```

4. **Start the development server:**
   ```bash
   composer run dev
   ```
   
   This command starts:
   - Laravel development server
   - Vite dev server with hot reload
   - Queue worker (if needed)
   - Log viewer (Pail)

The application is now ready to use! No database migrations or setup required.

### Production Build

For production deployment, build the assets first:
```bash
npm run build
php artisan serve
```

**Note:** The `.env.example` file is already configured to work without a database. The settings `SESSION_DRIVER=file`, `CACHE_STORE=file`, and `QUEUE_CONNECTION=sync` are already set correctly.

## Switching Implementations

You can switch between implementations by setting the `SUDOKU_IMPLEMENTATION` environment variable:

```env
SUDOKU_IMPLEMENTATION=livewire
# or
SUDOKU_IMPLEMENTATION=controllers
```

## Future Considerations

Potential future implementations might explore:
- MVC controllers with Vue.js
- JSON API with Vue.js frontend (SPA)
