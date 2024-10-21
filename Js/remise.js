// Grid Options: Contains all of the Data Grid configurations
const gridOptions = {
    pagination: true,
    paginationPageSize: 5,
    // Row Data: The data to be displayed.
    rowData: [
        {
            numCompte: '123456789',
            nomCompte: 'Auchan',
            date: '2024-10-01',
            nombreTransactions: 10,
            montant: '5000',
            devise: 'EUR'
        },
        {
            numCompte: '987654321',
            nomCompte: 'Auchan',
            date: '2024-09-29',
            nombreTransactions: 8,
            montant: '3200',
            devise: 'EUR'
        },
        {
            numCompte: '654321987',
            nomCompte: 'Auchan',
            date: '2024-09-25',
            nombreTransactions: 15,
            montant: '7600',
            devise: 'EUR'
        },
        {
            numCompte: '456789123',
            nomCompte: 'Auchan',
            date: '2024-09-20',
            nombreTransactions: 12,
            montant: '4200',
            devise: 'EUR'
        },
        {
            numCompte: '321654987',
            nomCompte: 'Auchan',
            date: '2024-09-18',
            nombreTransactions: 9,
            montant: '5400',
            devise: 'EUR'
        }
    ],
    // Column Definitions: Defines the columns to be displayed.
    columnDefs: [
        { headerName: "Numéro du compte", field: "numCompte", sortable: true, filter: true, flex: 1 },
        { headerName: "Nom du compte", field: "nomCompte", sortable: true, filter: true, flex: 1 },
        { headerName: "Date", field: "date", sortable: true, filter: true, flex: 1 },
        { headerName: "Nombre de transactions", field: "nombreTransactions", sortable: true, filter: true, flex: 1 },
        { headerName: "Montant", field: "montant", sortable: true, filter: true, flex: 1 },
        { headerName: "Devise", field: "devise", sortable: true, filter: true, flex: 1 }
    ],
    domLayout: 'autoHeight',
};

const myGridElement = document.querySelector('#myGrid');
new agGrid.Grid(myGridElement, gridOptions);