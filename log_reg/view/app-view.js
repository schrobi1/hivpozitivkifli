class AppView{
    static SetupNavigation(methods)
	{
		var links = document.querySelectorAll('#main .inside a');
		
		for(var i = 0; i < links.length; i++)
		{
			var link = links[i];
			
			link.setAttribute('href', i);
			
			link.onclick = function(evt)
			{
				evt.preventDefault();
				
				var x = this.getAttribute('href');
				x = parseInt(x);
				methods[x]();
			};
		}
	}
    
}