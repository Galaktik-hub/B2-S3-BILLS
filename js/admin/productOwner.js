// Grid Options: Contains all of the Data Grid configurations
const gridOptions = {
    pagination: true,
    paginationPageSize: 10,
    // Row Data: The data to be displayed.
    rowData: [
        {
            numSiren: '123456789',
            raisonSociale: 'Auchan',
            nombreRemises: 10,
            montantTotal: '50000',
            devise: 'EUR'
        },
        {
            numSiren: '987654321',
            raisonSociale: 'Carrefour',
            nombreRemises: 8,
            montantTotal: '32000',
            devise: 'EUR'
        },
        {
            numSiren: '654321987',
            raisonSociale: 'Leclerc',
            nombreRemises: 15,
            montantTotal: '76000',
            devise: 'EUR'
        },
        {
            numSiren: '456789123',
            raisonSociale: 'Intermarché',
            nombreRemises: 12,
            montantTotal: '42000',
            devise: 'EUR'
        },
        {
            numSiren: '321654987',
            raisonSociale: 'Casino',
            nombreRemises: 9,
            montantTotal: '54000',
            devise: 'EUR'
        }
    ],
    columnDefs: [
        { headerName: "N° Siren", field: "numSiren", sortable: true, filter: true, flex: 1 },
        { headerName: "Raison Sociale", field: "raisonSociale", sortable: true, filter: true, flex: 1 },
        { headerName: "Nombre de Remises", field: "nombreRemises", sortable: true, filter: true, flex: 1 },
        { headerName: "Montant Total", field: "montantTotal", sortable: true, filter: true, flex: 1 },
        { headerName: "Devise", field: "devise", sortable: true, filter: true, flex: 1 }
    ],
    domLayout: 'autoHeight',
};

const myGridElement = document.querySelector('#myGrid');
new agGrid.Grid(myGridElement, gridOptions);