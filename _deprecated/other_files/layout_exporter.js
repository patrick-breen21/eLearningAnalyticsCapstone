Liferay.LayoutExporter = {
	all: function(options) {
		options = options || {};

		var pane = options.pane;
		var obj = options.obj;
		var publish = options.publish;

		if (obj.checked) {
			jQuery(pane).hide();

			if (!publish) {
				jQuery('#publishBtn').show();
				jQuery('#selectBtn').hide();
			}
			else {
				jQuery('#changeBtn').hide();
			}
		}
	},

	details: function(options) {
		options = options || {};

		var toggle = options.toggle;
		var detail = options.detail;

		var img = jQuery(toggle)[0];

		if (jQuery(detail).css('display') == 'none') {
			jQuery(detail).slideDown('normal');
			img.src = Liferay.LayoutExporter.icons.minus;
		}
		else {
			jQuery(detail).slideUp('normal');
			img.src = Liferay.LayoutExporter.icons.plus;
		}
	},

	icons: {
		minus: themeDisplay.getPathThemeImages() + '/arrows/01_minus.png',
		plus: themeDisplay.getPathThemeImages() + '/arrows/01_plus.png'
	},

	proposeLayout: function(options, selectedLayoutId, deleteProposalRedirect) {
		options = options || {};

		var url = options.url;
		var namespace = options.namespace;
		var reviewers = options.reviewers;
		var title = options.title;
		var articleIds = options.articleIds;
		var requestForChange = options.requestForChange;
		var pagesRedirect = options.pagesRedirect;
		var reviewerslist = "";
		var articleIdlist = "";
		var articleTitlelist = "";
		
		if(deleteProposalRedirect === undefined) {
			deleteProposalRedirect  = '';
		}
		
		if(requestForChange === undefined) {
			requestForChange  = false;
		}
		
		if(pagesRedirect === undefined) {
			pagesRedirect  = '';
		}
		
		var contents =
			"<div>" +
				"<form action='" + url + "' method='post' onsubmit='return Liferay.LayoutExporter.checkSelectVal()' >";
		if(requestForChange=='true'){
		if(articleIds.length > 0){
			contents +=
				"<textarea name='" + namespace + "description' style='height: 100px; width: 275px;'></textarea><br /><br />" +
				Liferay.Language.get('articles') + " <select name='" + namespace + "articleIds' multiple>";
			contents += "<option value='All'>All</option>";
			for (var i = 0; i < articleIds.length; i++) {
				contents += "<option value='" + articleIds[i].articleId + "'>" + articleIds[i].articleTitle + "</option>";
				articleIdlist += articleIds[i].articleId + ",";
				articleTitlelist += articleIds[i].articleTitle + ",";
			}

			
			contents += "</select><br /><br />";
			contents +=Liferay.Language.get('reviewer') + " <select id='selectBoxTest' name='" + namespace + "reviewUserIds' multiple>";
			contents += "<option value='All'>All</option>";
			for (var i = 0; i < reviewers.length; i++) {
				contents += "<option value='" + reviewers[i].userId + "'>" + reviewers[i].fullName + "</option>";
				reviewerslist += reviewers[i].userId + ",";
			}

			
			contents += "</select><br /><br />";
			contents += "<input type='hidden' name='" + namespace + "reviewUserIdList' value='"+reviewerslist+"'>";
			contents += "<input type='hidden' name='" + namespace + "articleIdlist' value='"+articleIdlist+"'>";
			contents += "<input type='hidden' name='" + namespace + "articleTitlelist' value='"+articleTitlelist+"'>";
			contents += "<input type='hidden' name='" + namespace + "selectedLayoutId' value='"+selectedLayoutId+"'>";
			contents += "<input type='hidden' name='" + namespace + "deleteProposalRedirect' value='"+deleteProposalRedirect+"'>";
			contents += "<input type='hidden' name='" + namespace + "requestForChange' value='"+requestForChange+"'>";
			contents += "<input type='hidden' name='" + namespace + "pagesRedirect' value='"+pagesRedirect+"'>";
			contents +=	"<input type='submit' value='" + Liferay.Language.get('proceed') + "' />";
		}
		}
		else{
		if (reviewers.length > 0) {
			contents +=
				"<textarea name='" + namespace + "description' style='height: 100px; width: 284px;'></textarea><br /><br />" +
				Liferay.Language.get('reviewer') + " <select id='selectBoxTest' name='" + namespace + "reviewUserIds' multiple>";
			contents += "<option value='All'>All</option>";
			for (var i = 0; i < reviewers.length; i++) {
				contents += "<option value='" + reviewers[i].userId + "'>" + reviewers[i].fullName + "</option>";
				reviewerslist += reviewers[i].userId + ",";
			}

			
			contents += "</select><br /><br />";
			contents += "<input type='hidden' name='" + namespace + "reviewUserIdList' value='"+reviewerslist+"'>";
			contents += "<input type='hidden' name='" + namespace + "selectedLayoutId' value='"+selectedLayoutId+"'>";
			contents += "<input type='hidden' name='" + namespace + "deleteProposalRedirect' value='"+deleteProposalRedirect+"'>";
			contents +=	"<input type='submit' value='" + Liferay.Language.get('proceed') + "' />";
		}
		else {
			contents +=
				Liferay.Language.get('no-reviewers-were-found') + "<br />" +
				Liferay.Language.get('please-contact-the-administrator-to-assign-reviewers') + "<br /><br />";
		}
	}

		contents +=
					"<input type='button' value='" + Liferay.Language.get('cancel') + "' onClick='Liferay.Popup.close(this);' />" +
				"</form>" +
			"</div>";

		Liferay.Popup(
			{
				'title': title,
				message: contents,
				noCenter: false,
				modal: true,
				width: 300
			}
		);
	},
	
	checkSelectVal:function()
	{

	var selectVal =jQuery('#selectBoxTest').val();
	if( selectVal == '' || selectVal == null || selectVal === null )
	{
	alert('Please select an option');
	return false;
	}
	return true;
	} ,

	publishToLive: function(options) {
		options = options || {};

		var messageId = options.messageId;
		var url = options.url;
		var title = options.title;

		if (!title) {
			title = Liferay.Language.get(messageId);
		}

		var exportLayoutsPopup = Liferay.Popup(
			{
				title: title,
				modal: true,
				width: 600,
				overflow: 'auto',
				messageId: messageId
			}
		);

		jQuery.ajax(
			{
				url: url,
				success: function(response) {
					jQuery(exportLayoutsPopup).html(response);
				}
			}
		);
	},

	selected: function(options) {
		options = options || {};

		var pane = options.pane;
		var obj = options.obj;
		var publish = options.publish;

		if (obj.checked) {
			jQuery(pane).show();

			if (!publish) {
				jQuery('#publishBtn').hide();
				jQuery('#selectBtn').show();
			}
			else {
				jQuery('#changeBtn').show();
			}
		}
	}
};