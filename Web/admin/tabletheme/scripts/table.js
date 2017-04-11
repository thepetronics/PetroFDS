$(document).ready(function() {
		$('#petrofds tfoot th').each( function () {
			var title = $('#petrofds thead th').eq( $(this).index() ).text();
			$(this).html( '<input type="text" style="width:90%;" placeholder="Search '+title+'" />' );
		});
			var table = $('#petrofds').DataTable( {
				"pageLength": 50,
				dom: 'T<"clear">lfrtip',
				"order": [[ 4, "desc" ]]
			});
		table.columns().eq( 0 ).each( function ( colIdx ) {
			$( 'input', table.column( colIdx ).footer() ).on( 'keyup change', function () {
				table
				.column( colIdx )
				.search( this.value )
				.draw();
				} );
		});
});