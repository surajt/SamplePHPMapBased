function cofirmDelete() {
	var con = confirm("Are you sure you want to delete");
	if(con) {
		return true;	
	} else {
		return false;	
	}
}


jQuery(document).ready(function() {
	jQuery.getJSON("json.php", function(data){
				 var activeStates = {},
            i,
            byState = {},
            stateCode;
			var active_state=[];
			for (i = 0; i < data.length; i++) {
			  stateCode = data[i]['state'].toUpperCase();
			  activeStates[stateCode] = 'active';
			  byState[stateCode] = byState[stateCode] || [];
			  byState[stateCode].push(data[i]);
			}
			
			var active_state=[];
			$.each( activeStates, function( key, val ) {
				active_state.push(key);
			});
			
			//alert(active_state);
			jQuery('#jvm-map').vectorMap({
		    map: 'usa_en',
		    enableZoom: true,
			zoomOnScroll: true,
		    showTooltip: true,
			selectedRegions: active_state,			
			normalizeFunction: 'linear',
			
    		
			
			borderColor:'#000000',
			showLabels: true,
			
			//hoverColor: '#FFCC99',
			hoverColor: null,
			
			selectedColor:'#f6a126',
			color: '#f4f3f0',
			
			borderOpacity: 0.5,
			
			
            multiSelectRegion: true,
			onRegionClick: function(element, code, region)
			{
				//element.fillColor='#f6a126';
				console.log(element);
				$('#branch_data').empty();
				$('#branch_data').addClass('row');
				var code = code.toUpperCase();
				
				
				
				$('#branch_data').append("<h4>"+region+" ("+byState[code].length+") </h4>");
				for (i = 0; i < byState[code].length; i++) {
					stateData = byState[code][i];
					
					var branch_id 		= 	stateData['branch_name'];
					var contact_info 	=	stateData['contact_info'];
					var phone 			=	stateData['phone'];
					
					var email 			=	stateData['email'];
					var zip_code 		=	stateData['zip_code'];
					var state 			=	stateData['state'];
					var city 			=	stateData['city'];
					
					var contact_person 	=	stateData['contact_person'];
					
					//var bmcontact_info 	=	stateData['bmcontact_info'];
					
					var output="";
					
						output+="<h4>"+branch_id+"</h4>"+contact_info;
					
					if(city!="") {
						output+="<br>"+city;	
					}
					if(state!="") {
						output+=", "+state;		
					}
					if(zip_code!="") {
						output+=" "+zip_code;	
					}
					if(phone!="") {
						output+="<br>"+phone;		
					}
					
					
					if(email!="") {
						output+="<hr style='border-style: inset;margin: 0.5em auto;'>";
						output+="<strong> Manager: "+contact_person+"</strong>";
						
					}
						$('#branch_data').append($('<div/>').addClass('col-md-3 margin-5').html("<div class=' sidebarbox-height boxclsbranch'>"+output+" </div>"));
					
				}
				
			},
			onRegionLabelShow: function(e, label, code){
				//e.preventDefault();
			},
			onRegionSelected: function(e, code, isSelected){
				
				//e.preventDefault();
			}
		});
			
			
			
			
	});
});