// Grid Options: Contains all of the Data Grid configurations
const gridOptions = {
    pagination: true,
    paginationPageSize: 10,
    rowData: [
        { numDossier: '1', siren: '123456789', date: '2024-01-15', numCarte: '4111 1111 1111 1111', reseau: 'Visa', devise: 'EUR' },
        { numDossier: '2', siren: '987654321', date: '2024-02-10', numCarte: '5500 0000 0000 0004', reseau: 'MasterCard', devise: 'EUR' },
        { numDossier: '3', siren: '654321987', date: '2024-03-20', numCarte: '3400 0000 0000 009', reseau: 'American Express', devise: 'EUR' },
        { numDossier: '4', siren: '456789123', date: '2024-04-25', numCarte: '6011 0000 0000 0004', reseau: 'Discover', devise: 'EUR' },
        { numDossier: '5', siren: '321654987', date: '2024-05-05', numCarte: '4000 0000 0000 0002', reseau: 'Visa', devise: 'EUR' }
    ],
    columnDefs: [
        { headerName: "Dossier Impayé", field: "numDossier", sortable: true, filter: true, flex: 1 },
        { headerName: "Numéro Siren", field: "siren", sortable: true, filter: true, flex: 1 },
        { headerName: "Date", field: "date", sortable: true, filter: true, flex: 1 },
        { headerName: "Numéro Carte Bancaire", field: "numCarte", sortable: true, filter: true, flex: 1 },
        { headerName: "Réseau", field: "reseau", sortable: true, filter: true, flex: 1 },
        { headerName: "Devise", field: "devise", sortable: true, filter: true, flex: 1 }
    ],
    domLayout: 'autoHeight',
};

const myGridElement = document.querySelector('#myGrid');
new agGrid.Grid(myGridElement, gridOptions);