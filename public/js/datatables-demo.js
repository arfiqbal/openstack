// Call the dataTables jQuery plugin
$(document).ready(function() {
  //$('.dataTable').DataTable();
  $('.dataTable thead th').each( function () {
    var title = $(this).text();
    $(this).html( '<input type="text" '+title+'" />' );
} );

// DataTable
var table = $('.dataTable').DataTable();

// Apply the search
table.columns().every( function () {
    var that = this;

    $( 'input', this.footer() ).on( 'keyup change clear', function () {
        if ( that.search() !== this.value ) {
            that
                .search( this.value )
                .draw();
        }
    } );
} );
});
