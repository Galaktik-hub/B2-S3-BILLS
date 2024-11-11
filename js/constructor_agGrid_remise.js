// Génère automatiquement les colonnes à partir des noms des champs
function createDynamicColumns(columnNames) {
    return columnNames.map(name => ({
        headerName: name.charAt(0).toUpperCase() + name.slice(1),
        field: name,
        sortable: true,
        filter: true,
        flex: 1
    }));
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
new agGrid.Grid(myGridElement, gridOptions);

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
    gridOptions.api.exportDataAsCsv({
        fileName: fileName,
        columnSeparator: ','
    });
}

function exportFileXls() {
    // Récupère les données de la grille en format JSON
    const rowData = [];
    gridOptions.api.forEachNode(node => rowData.push(node.data));

    // Convertit les données en une feuille Excel
    const worksheet = XLSX.utils.json_to_sheet(rowData);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Données");

    // Génère le fichier Excel
    XLSX.writeFile(workbook, fileName + ".xlsx");
}

function exportFilePdf() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('landscape');

    // Récupérer les données de la grille et les colonnes
    const rowData = [];
    gridOptions.api.forEachNode(node => rowData.push(node.data));

    const columnNames = gridOptions.columnDefs.map(colDef => colDef.headerName);

    // jspdf-autotable pour générer le tableau
    doc.autoTable({
        head: [columnNames],
        body: rowData.map(row => columnNames.map(col => row[col])),
        startY: 10,
    });

    doc.save(fileName + ".pdf");
}

document.getElementById('exportButton').addEventListener('click', exportFile);