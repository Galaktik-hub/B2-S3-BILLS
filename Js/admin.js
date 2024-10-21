// Grid Options: Contains all of the Data Grid configurations
const gridOptions = {
    pagination: true,
    paginationPageSize: 10,
    // Row Data: The data to be displayed.
    rowData: [
        { numClient: '1', siren: '123456789', raisonSociale: 'Carrefour', login: 'carrefourUser' },
        { numClient: '2', siren: '987654321', raisonSociale: 'Auchan', login: 'auchanUser' },
        { numClient: '3', siren: '654321987', raisonSociale: 'Carrefour', login: 'carrefourUser2' },
        { numClient: '4', siren: '456789123', raisonSociale: 'Auchan', login: 'auchanUser2' },
        { numClient: '5', siren: '321654987', raisonSociale: 'Carrefour', login: 'carrefourUser3' },
    ],

    // Column Definitions: Defines the columns to be displayed.
    columnDefs: [
        { headerName: "Numéro Client", field: "numClient", sortable: true, filter: true, flex: 1 },
        { headerName: "Siren", field: "siren", sortable: true, filter: true, flex: 1},
        { headerName: "Raison Sociale", field: "raisonSociale", sortable: true, filter: true, flex: 1},
        { headerName: "Login", field: "login", sortable: true, filter: true, flex: 1}
    ],
    domLayout: 'autoHeight',
};

const myGridElement = document.querySelector('#myGrid');
new agGrid.Grid(myGridElement, gridOptions);