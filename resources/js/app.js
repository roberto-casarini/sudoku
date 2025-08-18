import './bootstrap';
import Alpine from 'alpinejs'

window.Alpine = Alpine

// Inizializza lo store (puoi metterlo in app.js o in uno script nella pagina)
document.addEventListener('alpine:init', () => {
    Alpine.store('game', {
        cells: [],
        game_status: '',
        async startGame() {
            //this.loading = true;
            
            try {
                const response = await fetch('/start-game', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    //body: JSON.stringify({ cell, value })
                });

                if (!response.ok) throw new Error('Move failed');
                const resp = await response.json();
                this.cells = resp.cells;
                this.game_status = resp.game_status;
                return resp;
            } finally {
                //this.loading = false;
            }
        },
        resetGame() {

        },
        backOneMove() {

        },
        setCellValue() {

        },
        setStatus(status) {
            
        },
        getCell(coord) {
            const pieces = coord.split('-');
            return this.cells.find(function (cell) {
                const myCell = Alpine.raw(cell);
                return (myCell.xCoordinate === pieces[0]) && (myCell.yCoordinate === pieces[1]);  
            });
        }
    });
});

Alpine.start()
