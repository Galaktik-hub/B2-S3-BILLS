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
        'row-red-5': params => getAmountValue(params) < -500,
    },
};

const myGridElement = document.querySelector('#myGrid');
new agGrid.Grid(myGridElement, gridOptions);