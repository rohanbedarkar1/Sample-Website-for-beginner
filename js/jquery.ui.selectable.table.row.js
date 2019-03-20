$(function() {
 
    /*
     * Updates the total span based on the selected table rows.
     * Here, we're summing the balance column.  This behavior is defined
     * as a function here because it's used in several selectable event 
     * handlers below.
     *
     */
    function updateTotal( $selectees ) {
		
        selected = $.makeArray( $selectees.filter( ".ui-selected" ) );
 
        var total = selected.reduce( function( a, b ) {
		var str1= $( b ).children( "td:eq(0)" ).text() ;
		var str2= $( b ).children( "td:eq(1)" ).text() ;
		var str3= $( b ).children( "td:eq(2)" ).text() ;
            return  str1.concat(",",str2,",",str3);
        }, "" );
		
       /* var val =   $( ".total > span " ).text( total );  */
	   var value = total;
		var splitVal = value.split(",") ;
		if(splitVal.length >1)
		{
		document.getElementsByName('id')[0].value = splitVal[0];
		document.getElementsByName('custname')[0].value = splitVal[1];
		}
 
    }
 
    $( "table > tbody" ).selectable({
 
        // Don't allow individual table cell selection.
        filter: ":not(td)",
 
        // Update the initial total to 0, since nothing is selected yet.
        create: function( e, ui ) {
            updateTotal( $() );
        },
 
        // When a row is selected, add the highlight class to the row and
        // update the total.
        selected: function( e, ui ) {
            $( ui.selected ).addClass( "ui-state-highlight" );
            var widget = $( this ).data( "uiSelectable" );
            updateTotal( widget.selectees );
        },
 
        // When a row is unselected, remove the highlight class from the row
        // and update the total.
        unselected: function( e, ui ) {
            $( ui.unselected ).removeClass( "ui-state-highlight" );
            var widget = $( this ).data( "uiSelectable" )
            updateTotal( widget.selectees );
        }
    });
 
});