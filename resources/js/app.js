import './bootstrap';
import Alpine from 'alpinejs'

window.Alpine = Alpine

// Inizializza lo store (puoi metterlo in app.js o in uno script nella pagina)
document.addEventListener('alpine:init', () => {
    Alpine.store('game', {
        cells: [],
        game_status: '',
        cell_selected: null,
        cell_selected_values: [],
        error: '',
        error_title: '',
        error_type: '',
        error_timeout: 3000,

        selectCell(coord, value) {
            this.cell_selected = coord;
            this.cell_selected_values = value;
        },
        setError(error, error_title, error_type, error_timeout) {
            this.error = error;
            this.error_title = error_title;
            this.error_type = error_type;
            this.error_timeout = error_timeout;
        },
        resetError() {
            this.error = '';
            this.error_title = '';
            this.error_type = '';
            this.error_timeout = 3000;
        },
        getCell(coord) {
            const pieces = coord.split('-');
            return this.cells.find(function (cell) {
                const myCell = Alpine.raw(cell);
                return (myCell.xCoordinate === pieces[0]) && (myCell.yCoordinate === pieces[1]);  
            });
        },
        manageRequest(url, body = null) {
            //this.loading = true;
            return new Promise(async (resolve, reject) => {
                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: body
                    });

                    if (!response.ok) throw new Error('Move failed');
                    const resp = await response.json();
                    if (resp.request_status === 'ERROR') {
                        this.setError(resp.message, resp.error_title, resp.error_type, resp.error_timeout);
                    } else if (resp.request_status === 'OK') {
                        this.cells = resp.cells;
                        this.game_status = resp.game_status;
                    }
                    resolve(resp);
                } catch(error) {
                    reject(error);
                } finally {
                    //this.loading = false;
                }
            });
        },
        startGame() {
            this.manageRequest('/start-game');
        },
        setCellValueSetup(coord, value) {
            const body = JSON.stringify({ coord, value });
            this.manageRequest('/set-cell-value-setup', body)
                .then((resp) => {
                    this.cell_selected = resp.cell;
                    this.cell_selected_values = resp.cell_value;
                });
        },
        setCellValue(coord, value, possibilities) {
            const body = JSON.stringify({ coord, value, possibilities });
            this.manageRequest('/set-cell-value', body)
                .then((resp) => {
                    console.log(resp);
                    this.cell_selected = resp.cell;
                    this.cell_selected_values = resp.cell_value;
                });
        },
        setStatus(status) {
            const body = JSON.stringify({ status });
            this.manageRequest('/set-status', body);
            this.cell_selected = null;
            this.cell_selected_values = [];
        },
        resetGame() {
            this.manageRequest('/reset');
        },
        backOneMove() {
            this.manageRequest('/back-one-move')
                .then((resp) => {
                    console.log(resp);
                    this.cell_selected = resp.cell;
                    this.cell_selected_values = resp.cell_value;
                });
        }
    });
});

Alpine.start()
