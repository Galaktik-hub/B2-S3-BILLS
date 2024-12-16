// Génère automatiquement les colonnes à partir des noms des champs
function createDynamicColumns(columnNames) {
    return columnNames.map(name => {
        if (name === "Date de Remise") {
            return {
                headerName: name.charAt(0).toUpperCase() + name.slice(1),
                field: name,
                sortable: true,
                filter: 'agDateColumnFilter',
                flex: 1,
                comparator: (valueA, valueB) => {
                    const dateA = new Date(valueA);
                    const dateB = new Date(valueB);
                    return dateA - dateB;
                },
                filterParams: {
                    comparator: (filterLocalDateAtMidnight, cellValue) => {
                        const cellDate = new Date(cellValue);

                        if (cellDate < filterLocalDateAtMidnight) {
                            return -1;
                        } else if (cellDate > filterLocalDateAtMidnight) {
                            return 1;
                        }
                        return 0;
                    },
                    browserDatePicker: true,
                },
                valueFormatter: params => {
                    const date = new Date(params.value);
                    return date.toLocaleDateString();
                }
            };
        }

        return {
            headerName: name.charAt(0).toUpperCase() + name.slice(1),
            field: name,
            sortable: true,
            filter: true,
            flex: 1
        };
    });
}

// The function to get the value amount of the grid
function getAmountValue(params) {
    return (
        params.data["Montant Total"] ||
        params.data["Montant total"] ||
        params.data["Montant"] ||
        0
    );
}

// Grid Options: Contains all the Data Grid configurations
const gridOptions = {
    pagination: true,
    paginationPageSize: 10,
    paginationPageSizeSelector: [10, 20, 50, 100],
    rowData: data,
    columnDefs: createDynamicColumns(columnNames),
    domLayout: 'autoHeight',
    rowStyle: {cursor: "pointer"},
    localeText: localeText,

    // The condition to have a different style for the negative amounts
    rowClassRules: {
        'row-red-0': params => getAmountValue(params) < 0 && getAmountValue(params) >= -100,
        'row-red-1': params => getAmountValue(params) < -100 && getAmountValue(params) >= -200,
        'row-red-2': params => getAmountValue(params) < -200 && getAmountValue(params) >= -300,
        'row-red-3': params => getAmountValue(params) < -300 && getAmountValue(params) >= -400,
        'row-red-4': params => getAmountValue(params) < -400 && getAmountValue(params) >= -500,
        'row-red-5': params => getAmountValue(params) < -500 && getAmountValue(params) >= -600,
        'row-red-6': params => getAmountValue(params) < -600 && getAmountValue(params) >= -700,
        'row-red-7': params => getAmountValue(params) < -700 && getAmountValue(params) >= -800,
        'row-red-8': params => getAmountValue(params) < -800 && getAmountValue(params) >= -900,
        'row-red-9': params => getAmountValue(params) < -900
    },

    onRowClicked: params => {
        const numRemise = params.data['N° Remise'];
        window.location.href = `transactions.php?numRemise=${numRemise}`;
    }
};

const myGridElement = document.querySelector('#myGrid');
gridApi = agGrid.createGrid(myGridElement, gridOptions);

function exportFile() {
    const format = document.getElementById('format').value;
    if (format === 'csv') {
        exportFileCsv();
    } else if (format === 'xls') {
        exportFileXls();
    } else {
        exportFilePdf();
    }
}

function exportFileCsv() {
    gridApi.exportDataAsCsv({
        fileName: fileName,
        columnSeparator: ','
    });
}

function exportFileXls() {
    // Récupère uniquement les lignes affichées
    const displayedRowData = [];
    for (let i = 0; i < gridApi.getDisplayedRowCount(); i++) {
        const node = gridApi.getDisplayedRowAtIndex(i);
        if (node) displayedRowData.push(node.data);
    }

    // Convertit les données en une feuille Excel
    const worksheet = XLSX.utils.json_to_sheet(displayedRowData);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Données");

    // Génère le fichier Excel
    XLSX.writeFile(workbook, fileName + ".xlsx");
}

function exportFilePdf() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('landscape');

    // Récupère uniquement les lignes affichées
    const displayedRowData = [];
    for (let i = 0; i < gridApi.getDisplayedRowCount(); i++) {
        const node = gridApi.getDisplayedRowAtIndex(i);
        if (node) displayedRowData.push(node.data);
    }

    const columnNames = gridOptions.columnDefs.map(colDef => colDef.headerName);

    // jspdf-autotable pour générer le tableau
    doc.autoTable({
        head: [columnNames],
        body: displayedRowData.map(row => columnNames.map(col => row[col])),
        startY: 10,
    });

    doc.save(fileName + ".pdf");
}

document.getElementById('exportButton').addEventListener('click', exportFile);

// Ajoute un écouteur d'événements agGrid pour mettre à jour le nombre de remises
gridApi.addEventListener('modelUpdated', () => {
    const displayedRowCount = gridApi.getDisplayedRowCount();
    document.getElementById('rowCountInfo').textContent = `${displayedRowCount} remises trouvées.`;
});

// Initialisation pour afficher dès le départ
const initialRowCount = gridApi.getDisplayedRowCount();
document.getElementById('rowCountInfo').textContent = `${initialRowCount} remises trouvées.`;
