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

// Grid Options: Contains all of the Data Grid configurations
const gridOptions = {
    pagination: true,
    paginationPageSize: 10,
    rowData: data,
    columnDefs: createDynamicColumns(columnNames),
    domLayout: 'autoHeight',
};

const myGridElement = document.querySelector('#myGrid');
new agGrid.Grid(myGridElement, gridOptions);