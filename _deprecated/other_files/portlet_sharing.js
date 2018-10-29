Liferay.PortletSharing = {
	showNetvibesInfo: function(netvibesURL) {
		var popup = Liferay.Popup(
			{
				width: 550,
				modal: true,
				title: Liferay.Language.get('add-to-netvibes')
			}
		);

		var portletURL = Liferay.PortletURL.createResourceURL();

		portletURL.setPortletId(133);

		portletURL.setParameter("netvibesURL", netvibesURL);

		jQuery.ajax(
			{
				url: portletURL.toString(),
				success: function(message) {
					popup.html(message);
				}
			}
		);
	},
	showWidgetInfo: function(widgetURL) {
		var popup = Liferay.Popup(
			{
				width: 550,
				modal: true,
				title: Liferay.Language.get('add-to-any-website')
			}
		);

		var portletURL = Liferay.PortletURL.createResourceURL();

		portletURL.setPortletId(133);

		portletURL.setParameter("widgetURL", widgetURL);

		jQuery.ajax(
			{
				url: portletURL.toString(),
				success: function(message) {
					popup.html(message);
				}
			}
		);
	}
};