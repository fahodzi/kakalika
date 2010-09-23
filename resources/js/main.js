function confirmAndRedirect(message, path)
{
	if(confirm(message))
	{
		document.location = path;
	}
}