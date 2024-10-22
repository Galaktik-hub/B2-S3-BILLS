// Grid Options: Contains all of the Data Grid configurations
const gridOptions = {
    pagination: true,
    paginationPageSize: 10,
    // Row Data: The data to be displayed.
    rowData: [
        { numSiren: '123456789', raisonSociale: 'Auchan', montantTotal: '50000' },
        { numSiren: '987654321', raisonSociale: 'Carrefour', montantTotal: '32000' },
        { numSiren: '654321987', raisonSociale: 'Leclerc', montantTotal: '76000' },
        { numSiren: '456789123', raisonSociale: 'Intermarché', montantTotal: '42000' },
        { numSiren: '321654987', raisonSociale: 'Casino', montantTotal: '54000' }
    ],

    columnDefs: [
        { headerName: "N° Siren", field: "numSiren", sortable: true, filter: true, flex: 1 },
        { headerName: "Raison Sociale", field: "raisonSociale", sortable: true, filter: true, flex: 1 },
        { headerName: "Montant Total", field: "montantTotal", sortable: true, filter: true, flex: 1 }
    ],
    domLayout: 'autoHeight',
};

const myGridElement = document.querySelector('#myGrid');
new agGrid.Grid(myGridElement, gridOptions);