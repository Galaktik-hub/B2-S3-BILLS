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
    onRowClicked: event => {
        // Récupérer le numClient
        const numClient = event.data["N° Client"];
        // Redirection
        window.location.href = `adminSeeClient.php?numClient=${numClient}`;
    }
};

const myGridElement = document.querySelector('#myGrid');
new agGrid.Grid(myGridElement, gridOptions);