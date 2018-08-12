Liferay.Upload = new Liferay.Class(
	{

		/**
		 * OPTIONS
		 *
		 * Required
		 * allowedFileTypes {string}: A comma-seperated list of allowable filetypes.
		 * container {string|object}: The container where the uploader will be placed.
		 * maxFileSize {number}: The maximum file size that can be uploaded.
		 * uploadFile {string}: The URL to where the file will be uploaded.
		 *
		 * Optional
		 * buttonHeight {number}: The buttons height.
		 * buttonText {string}: The text to be displayed on the upload button.
		 * buttonUrl {string}: A relative (to the flash) file that will be used as the background image of the button.
		 * buttonWidth {number}: The buttons width.
		 * fallbackContainer {string|object}: A jQuery selector or DOM element of the container holding a fallback (in case flash is not supported).
		 * fileDescription {string}: A string describing what files can be uploaded.
		 * namespace {string}: A unique string so that the global callback methods don't collide.
		 * overlayButton {boolean}: Whether the button is overlayed upon the HTML link.
		 *
		 * Callbacks
		 * onFileComplete {function}: Called whenever a file is completely uploaded.
		 * onUploadsComplete {function}: Called when all files are finished being uploaded, and is passed no arguments.
		 * onUploadProgress {function}: Called during upload, and is also passed in the number of bytes loaded as it's second argument.
		 * onUploadError {function}: Called when an error in the upload occurs. Gets passed the error number as it's only argument.
		 */

		initialize: function(options) {
			var instance = this;

			options = options || {};

			instance._container = jQuery(options.container);
			instance._fallbackContainer = jQuery(options.fallbackContainer || []);
			instance._namespaceId = options.namespace || '_liferay_pns_' + Liferay.Util.randomInt() + '_';
			instance._maxFileSize = options.maxFileSize || 0;
			instance._allowedFileTypes = options.allowedFileTypes;
			instance._uploadFile = options.uploadFile;

			instance._buttonUrl = options.buttonUrl || '';
			instance._buttonWidth = options.buttonWidth || 500;
			instance._buttonHeight = options.buttonHeight || 30;
			instance._buttonText = options.buttonText || '';

			instance._buttonPlaceHolderId = instance._namespace('buttonHolder');
			instance._overlayButton = options.overlayButton || true;

			instance._onFileComplete = options.onFileComplete;
			instance._onUploadsComplete = options.onUploadsComplete;
			instance._onUploadProgress = options.onUploadProgress;
			instance._onUploadError = options.onUploadError;

			instance._classicUploaderParam = 'uploader=classic';
			instance._newUploaderParam = 'uploader=new';

			instance._queueCancelled = false;

			instance._flashVersion = deconcept.SWFObjectUtil.getPlayerVersion().major;

			// Check for an override via the query string

			var loc = location.href;
			/*
			 *	MYCAMPUS-161: By default show the classic one.
			 *  Since its the only one no point showing option(s)
			 */
			if (instance._fallbackContainer.length) {
				instance._fallbackContainer.show();

				instance._setupIframe();

				return;
			}

			// Language keys

			instance._browseText = Liferay.Language.get('browse-you-can-select-multiple-files');
			instance._cancelUploadsText = Liferay.Language.get('cancel-all-uploads');
			instance._cancelFileText = Liferay.Language.get('cancel-upload');
			instance._clearRecentUploadsText = Liferay.Language.get('clear-recent-uploads');
			instance._fileListPendingText = Liferay.Language.get('x-files-ready-to-be-uploaded', '0');
			instance._fileListText = Liferay.Language.get('file-list');
			instance._fileTypesDescriptionText = options.fileDescription || instance._allowedFileTypes;
			instance._uploadsCompleteText = Liferay.Language.get('all-uploads-complete');
			instance._uploadStatusText = Liferay.Language.get('uploading-file-x-of-x', ['[$POS$]','[$TOTAL$]']);
			instance._uploadFilesText = Liferay.Language.get('upload-files');

			if (instance._fallbackContainer.length) {				
				//MYCAMPUS-161: Since only classic uploader being used; no point showing options
				instance._useFallbackText = ""; //Liferay.Language.get('use-the-classic-uploader');
				instance._useNewUploaderText = ""; //Liferay.Language.get('use-the-new-uploader');
			}

			if (instance._flashVersion < 9 && instance._fallbackContainer.length) {
				instance._fallbackContainer.show();

				instance._setupIframe();

				return;
			}

			instance._setupCallbacks();
			instance._setupUploader();
		},

		cancelUploads: function() {
			var instance = this;

			var stats = instance._getStats();

			while (stats.files_queued > 0) {
				instance._uploader.cancelUpload();

				stats = instance._getStats();
			}

			if (stats.in_progress === 0) {
				instance._queueCancelled = false;
			}

			instance._uploadButton.hide();
			instance._cancelButton.hide();
		},

		fileAdded: function(file) {
			var instance = this;

			var listingFiles = instance._fileList;
			var listingUl = listingFiles.find('ul');

			if (!listingUl.length) {
				instance._listInfo.append('<h4>' + instance._fileListText + '</h4>');

				listingFiles.append('<ul class="lfr-component"></ul>');

				instance._uploadTarget.append(instance._clearUploadsButton);
				instance._clearUploadsButton.hide();

				instance._cancelButton.click(
					function() {
						instance.cancelUploads();
						instance._clearUploadsButton.hide();
					}
				);
			}

			instance._cancelButton.show();
			instance._uploadButton.show();

			listingFiles = listingFiles.find('ul');

			var fileId = instance._namespace(file.id);
			var fileName = file.name;

			var li = jQuery(
				'<li class="upload-file" id="' + fileId + '">' +
					'<span class="file-title">' + fileName + '</span>' +
					'<span class="progress-bar">' +
						'<span class="progress" id="' + fileId + 'progress"></span>' +
					'</span>' +
					'<a class="lfr-button cancel-button" href="javascript: ;" id="' + fileId+ 'cancelButton">' + instance._cancelFileText + '</a>' +
				'</li>');

			li.find('.cancel-button').click(
				function() {
					instance._uploader.cancelUpload(file.id);
				}
			);

			var uploadedFiles = listingFiles.find('.upload-complete');

			uploadedFiles = uploadedFiles.filter(':first');

			if (uploadedFiles.length) {
				uploadedFiles.before(li);
			}
			else {
				listingFiles.append(li);
			}

			var stats = instance._getStats();
			var listLength = stats.files_queued;

			instance._updateList(listLength);
		},

		fileCancelled: function(file, error_code, msg) {
			var instance = this;

			var stats = instance._getStats();

			var fileId = instance._namespace(file.id);
			var fileName = file.name;
			var li = jQuery('#' + fileId);

			instance._updateList(stats.files_queued);

			li.fadeOut('slow');
		},

		fileUploadComplete: function(file) {
			var instance = this;

			var fileId = instance._namespace(file.id);
			var li = jQuery('#' + fileId);

			li.removeClass('file-uploading').addClass('upload-complete');

			var uploader = instance._uploader;
			var stats = instance._getStats();

			if (stats.files_queued > 0 && !instance._queueCancelled) {

				// Automatically start the next upload if the queue wasn't cancelled

				uploader.startUpload();
			}
			else if (stats.files_queued === 0 && !instance._queueCancelled) {

				// Call Queue Complete if there are no more files queued and the queue wasn't cancelled

				instance.uploadsComplete(file);
			}
			else {

				// Don't do anything. Remove the queue cancelled flag (if the queue was cancelled it will be set again)

				instance._queueCancelled = false;
			}

			if (instance._onFileComplete) {
				instance._onFileComplete(file);
			}
		},

		flashLoaded: function() {
			var instance = this;

			instance._setupControls();
		},

		uploadError: function(file, error_code, msg) {
			var instance = this;

			/*
			Error codes:
				-10 HTTP error
				-20 No upload script specified
				-30 IOError
				-40 Security error
				-50 Filesize too big
			*/

			if (error_code == SWFUpload.UPLOAD_ERROR.FILE_CANCELLED) {
				instance.fileCancelled(file, error_code, msg);
			}

			if (instance._onUploadError) {
				instance._onUploadError(arguments);
			}
		},

		uploadProgress: function(file, bytesLoaded) {
			var instance = this;
			var fileId = instance._namespace(file.id);
			var progress = document.getElementById(fileId + 'progress');
			var percent = Math.ceil((bytesLoaded / file.size) * 100);

			progress.style.width = percent + '%';

			if (instance._onUploadProgress) {
				instance._onUploadProgress(file, bytesLoaded);
			}
		},

		uploadsComplete: function(file) {
			var instance = this;

			instance._cancelButton.hide();
			instance._updateList(0, instance._uploadsCompleteText);
			instance._uploadButton.hide();

			if (instance._clearUploadsButton.is(':hidden')) {
				instance._clearUploadsButton.show();
			}

			if (instance._onUploadsComplete) {
				instance._onUploadsComplete();
			}

			var uploader = instance._uploader;

			uploader.setStats(
				{
					successful_uploads: 0
				}
			);
		},

		uploadStart: function(file) {
			var instance = this;

			var stats = instance._getStats();
			var listLength = (stats.successful_uploads + stats.upload_errors + stats.files_queued);
			var position = (stats.successful_uploads + stats.upload_errors + 1);

			var currentListText = instance._uploadStatusText.replace('[$POS$]', position).replace('[$TOTAL$]', listLength);
			var fileId = instance._namespace(file.id);

			instance._updateList(listLength, currentListText);

			var li = jQuery('#' + fileId);

			li.addClass('file-uploading');

			return true;
		},

		uploadSuccess: function(file, data) {
			var instance = this;

			instance.fileUploadComplete(file, data);
		},

		_clearUploads: function() {
			var instance = this;

			var completeUploads = instance._fileList.find('.upload-complete');

			completeUploads.fadeOut(
				'slow',
				function() {
					jQuery(this).remove();
				}
			);

			instance._clearUploadsButton.hide();
		},

		_getStats: function() {
			var instance = this;

			return instance._uploader.getStats();
		},

		_namespace: function(txt) {
			var instance = this;

			txt = txt || '';

			return instance._namespaceId + txt;

		},

		_setupCallbacks: function() {
			var instance = this;

			// Global callback references

			instance._cancelUploads = instance._namespace('cancelUploads');
			instance._fileAdded = instance._namespace('fileAdded');
			instance._fileCancelled = instance._namespace('fileCancelled');
			instance._flashLoaded = instance._namespace('flashLoaded');
			instance._uploadStart = instance._namespace('uploadStart');
			instance._uploadProgress = instance._namespace('uploadProgress');
			instance._uploadError = instance._namespace('uploadError');
			instance._uploadSuccess = instance._namespace('uploadSuccess');
			instance._fileUploadComplete = instance._namespace('fileUploadComplete');
			instance._uploadsComplete = instance._namespace('uploadsComplete');
			instance._uploadsCancelled = instance._namespace('uploadsCancelled');

			// Global swfUpload var

			instance._swfUpload = instance._namespace('cancelUploads');

			window[instance._cancelUploads] = function() {
				instance.cancelUploads.apply(instance, arguments);
			};

			window[instance._fileAdded] = function() {
				instance.fileAdded.apply(instance, arguments);
			};

			window[instance._fileCancelled] = function() {
				instance.fileCancelled.apply(instance, arguments);
			};

			window[instance._uploadStart] = function() {
				instance.uploadStart.apply(instance, arguments);
			};

			window[instance._uploadProgress] = function() {
				instance.uploadProgress.apply(instance, arguments);
			};

			window[instance._uploadError] = function() {
				instance.uploadError.apply(instance, arguments);
			};

			window[instance._fileUploadComplete] = function() {
				instance.fileUploadComplete.apply(instance, arguments);
			};

			window[instance._uploadSuccess] = function() {
				instance.uploadSuccess.apply(instance, arguments);
			};

			window[instance._uploadsComplete] = function() {
				instance.uploadsComplete.apply(instance, arguments);
			};

			window[instance._flashLoaded] = function() {
				instance.flashLoaded.apply(instance, arguments);
			};

		},

		_setupControls: function() {
			var instance = this;

			if (!instance._hasControls) {
				instance._uploadTargetId = instance._namespace('uploadTarget');
				instance._listInfoId = instance._namespace('listInfo');
				instance._fileListId = instance._namespace('fileList');

				instance._uploadTarget = jQuery('<div id="' + instance._uploadTargetId + '" class="float-container upload-target"></div>');

				instance._uploadTarget.css('position', 'relative');

				instance._listInfo = jQuery('<div id="' + instance._listInfoId + '" class="upload-list-info"></div>');
				instance._fileList = jQuery('<div id="' + instance._fileListId + '" class="upload-list"></div>');
				instance._cancelButton = jQuery('<a class="lfr-button cancel-uploads" href="javascript: ;">' + instance._cancelUploadsText + '</a>');
				instance._clearUploadsButton = jQuery('<a class="lfr-button clear-uploads" href="javascript: ;">' + instance._clearRecentUploadsText + '</a>');

				instance._browseButton = jQuery('<a class="lfr-button browse-button" href="javascript: ;">' + instance._browseText + '</a>');
				instance._uploadButton = jQuery('<a class="lfr-button upload-button" href="javascript: ;">' + instance._uploadFilesText + '</a>');

				instance._container.prepend([instance._uploadTarget[0], instance._listInfo[0], instance._fileList[0]]);
				instance._uploadTarget.append([instance._browseButton[0], instance._buttonPlaceHolder[0], instance._uploadButton[0], instance._cancelButton[0]]);

				instance._clearUploadsButton.click(
					function() {
						instance._clearUploads();
					}
				);

				if (instance._overlayButton) {
					var buttonWidth = instance._browseButton.outerWidth();
					var buttonHeight = instance._browseButton.outerHeight();
					var buttonOffset = instance._browseButton.offset();

					var flashObj = jQuery('#' + instance._uploader.movieName);

					flashObj.css(
						{
							left: buttonOffset.left,
							position: 'absolute',
							top: buttonOffset.top,
							zIndex: 100000
						}
					);

					instance._uploader.setButtonDimensions(buttonWidth, buttonHeight);
				}
				else {
					instance._browseButton.click(
						function() {
							instance._uploader.selectFiles();
						}
					);
				}

				instance._uploadButton.click(
					function() {
						instance._uploader.startUpload();
					}
				);

				instance._uploadButton.hide();
				instance._cancelButton.hide();

				if (instance._fallbackContainer.length) {
					instance._useFallbackButton = jQuery('<a class="use-fallback using-new-uploader" href="javascript: ;">' + instance._useFallbackText + '</a>');
					instance._fallbackContainer.after(instance._useFallbackButton);

					instance._useFallbackButton.click(
						function() {
							var fallback = jQuery(this);
							var newUploaderClass = 'using-new-uploader';
							var fallbackClass = 'using-classic-uploader';

							if (fallback.is('.' + newUploaderClass)) {
								instance._container.hide();
								instance._fallbackContainer.show();

								fallback.text(instance._useNewUploaderText);
								fallback.removeClass(newUploaderClass).addClass(fallbackClass);

								instance._setupIframe();

								var classicUploaderUrl = '';

								if (location.hash.length) {
									classicUploaderUrl = '&';
								}

								location.hash += classicUploaderUrl + instance._classicUploaderParam;
							}
							else {
								instance._container.show();
								instance._fallbackContainer.hide();
								fallback.text(instance._useFallbackText);
								fallback.removeClass(fallbackClass).addClass(newUploaderClass);

								location.hash = location.hash.replace(instance._classicUploaderParam, instance._newUploaderParam);
							}
						}
					);
				}

				instance._hasControls = true;
			}
		},

		_setupIframe: function() {
			var instance = this;

			if (!instance._fallbackIframe) {
				instance._fallbackIframe = instance._fallbackContainer.find('iframe[id$=-iframe]');

				if (instance._fallbackIframe.length) {
					var frameHeight = jQuery('#content-wrapper', instance._fallbackIframe[0].contentWindow).height() || 250;

					instance._fallbackIframe.height(frameHeight + 150);
				}
			}
		},

		_setupUploader: function() {
			var instance = this;

			if (instance._allowedFileTypes.indexOf('*') == -1) {
				var fileTypes = instance._allowedFileTypes.split(',');

				fileTypes = jQuery.map(
					fileTypes,
					function(value, key) {
						var fileType = value;

						if (value.indexOf('*') == -1) {
							fileType = '*' + value;
						}
						return fileType;
					}
				);

				instance._allowedFileTypes = fileTypes.join(';');
			}

			instance._buttonPlaceHolder = jQuery('<div id="' + instance._buttonPlaceHolderId + '"></div>');

			jQuery(document.body).append(instance._buttonPlaceHolder);

			instance._uploader = new SWFUpload(
				{
					upload_url: instance._uploadFile,
					target: instance._uploadTargetId,
					flash_url: themeDisplay.getPathContext() + '/html/js/misc/swfupload/swfupload_f10.swf',
					file_size_limit: instance._maxFileSize,
					file_types: instance._allowedFileTypes,
					file_types_description: instance._fileTypesDescriptionText,
					browse_link_innerhtml: instance._browseText,
					upload_link_innerhtml: instance._uploadFilesText,
					browse_link_class: 'browse-button liferay-button',
					upload_link_class: 'upload-button liferay-button',
					swfupload_loaded_handler: window[instance._flashLoaded],
					file_queued_handler: window[instance._fileAdded],
					upload_start_handler: window[instance._uploadStart],
					upload_progress_handler: window[instance._uploadProgress],
					upload_complete_handler: window[instance._fileUploadComplete],
					upload_success_handler: window[instance._uploadSuccess],
					upload_file_cancel_callback: window[instance._fileCancelled],
					upload_queue_complete_callback: window[instance._uploadsComplete],
					upload_error_handler: window[instance._uploadError],
					upload_cancel_callback: window[instance._cancelUploads],
					auto_upload : false,
					file_post_name: 'file',
					create_ui: true,
					button_image_url: instance._buttonUrl,
					button_width: instance._buttonWidth,
					button_window_mode: 'transparent',
					button_height: instance._buttonHeight,
					button_placeholder_id: instance._buttonPlaceHolderId,
					button_text: instance._buttonText,
					button_text_style: '',
					button_text_left_padding: 0,
					button_text_top_padding: 0,
					debug: false
				}
			);

			window[instance._swfUpload] = instance._uploader;
		},

		_updateList: function(listLength, message) {
			var instance = this;

			var infoTitle = instance._listInfo.find('h4');
			var listText = '';

			if (!message) {
				listText = instance._fileListPendingText;
				listText = listText.replace(/\d+/g, listLength);
			}
			else {
				listText = message;
			}

			infoTitle.html(listText);
		}
	}
);