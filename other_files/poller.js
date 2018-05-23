(function() {
	var _browserKey = Liferay.Util.randomInt();
	var _enabled = false;
	var _supportsComet = false;
	var _encryptedUserId = null;

	var _delays = [1, 2, 3, 4, 5, 7, 10];
	var _delayIndex = 0;
	var _delayAccessCount = 0;

	var _getEncryptedUserId = function() {
		return _encryptedUserId;
	};

	var _locked = false;

	var _maxDelay = _delays.length - 1;

	var _metaData = {
		startPolling: true,
		browserKey: _browserKey,
		companyId: themeDisplay.getCompanyId(),
		initialRequest: true
	};

	var _portlets = {};
	var _registeredPortlets = [];
	var _requestData = [_metaData];
	var _requestDelay = _delays[0];
	var _sendQueue = [];
	var _suspended = false;
	var _timerId = null;

	var _url = '/poller';
	var _receiveChannel = _url + '/receive';
	var _sendChannel = _url + '/send';

	var _closeCurlyBrace = '}';
	var _escapedCloseCurlyBrace = '[$CLOSE_CURLY_BRACE$]';

	var _openCurlyBrace = '{';
	var _escapedOpenCurlyBrace = '[$OPEN_CURLY_BRACE$]';

	var _cancelRequestTimer = function() {
		clearTimeout(_timerId);

		_timerId = null;
	};

	var _createRequestTimer = function() {
		_cancelRequestTimer();

		if (_enabled) {
			if (Poller.isSupportsComet()) {
				_receive();
			}
			else {
				_timerId = setTimeout(_receive, Poller.getDelay());
			}
		}
	};

	var _getReceiveUrl = function() {
		return _receiveChannel;
	};

	var _getSendUrl = function() {
		return _sendChannel;
	};

	var _processResponse = function(response) {
		if (Liferay.Util.isArray(response)) {
			var meta = response.shift();
			var chunk;

			var portletId;
			var portlet;

			for (var i = 0, length = response.length; i < length; i++) {
				chunk = response[i];

				portletId = chunk.portletId;
				portlet = _portlets[portletId];

				if (portlet) {
					if (meta.initialRequest) {
						chunk.data.initialRequest = true;
					}

					portlet.listener.call(portlet.scope || Poller, chunk.data, chunk.chunkId);

					if (chunk.data && chunk.data.pollerHintHighConnectivity) {
						_requestDelay = _delays[0];
						_delayIndex = 0;
					}
				}
			}

			if ('startPolling' in _metaData) {
				delete _metaData.startPolling;
			}

			if ('initialRequest' in _metaData) {
				_send();

				delete _metaData.initialRequest;
			}

			if (!meta.suspendPolling) {
				_createRequestTimer();
			}
		}
	};

	var _receive = function() {
		if (!_suspended) {
			_metaData.userId = _getEncryptedUserId();
			_metaData.timestamp = (new Date()).getTime();
			_metaData.portletIds = _registeredPortlets.join(',');

			var requestStr = jQuery.toJSON([_metaData]);

			jQuery.ajax(
				{
					url: _getReceiveUrl(),
					cache: false,
					data: {
						pollerRequest: requestStr
					},
					dataType: 'json',
					success: _processResponse,
					type: 'POST'
				}
			);
		}
	};

	var _releaseLock = function() {
		_locked = false;
	};

	var _sendComplete = function() {
		_releaseLock();
		_send();
	};

	var _send = function() {
		if (_enabled && !_locked && _sendQueue.length && !_suspended) {
			_locked = true;

			var data = _sendQueue.shift();

			_metaData.userId = _getEncryptedUserId();
			_metaData.timestamp = (new Date()).getTime();
			_metaData.portletIds = _registeredPortlets.join(',');

			var requestStr = jQuery.toJSON([_metaData].concat(data));

			jQuery.ajax(
				{
					url: _getSendUrl(),
					cache: false,
					complete: _sendComplete,
					data: {
						pollerRequest: requestStr
					},
					dataType: 'json',
					type: 'POST'
				}
			);
		}
	};

	var Poller = {
		init: function(options) {
			var instance = this;

			instance.setEncryptedUserId(options.encryptedUserId);
			instance.setSupportsComet(options.supportsComet);
		},

		url: _url,

		addListener: function(key, listener, scope) {
			_portlets[key] = {
				listener: listener,
				scope: scope
			};

			if (jQuery.inArray(key, _registeredPortlets) == -1) {
				_registeredPortlets.push(key);
			}

			if (!_enabled) {
				_enabled = true;

				_receive();
			}
		},

		getDelay: function() {
			if (_delayIndex <= _maxDelay) {
				_requestDelay = _delays[_delayIndex];
				_delayAccessCount++;

				if (_delayAccessCount == 3) {
					_delayIndex++;
					_delayAccessCount = 0;
				}
			}

			return _requestDelay * 1000;
		},

		getReceiveUrl: _getReceiveUrl,
		getSendUrl: _getSendUrl,

		isSupportsComet: function() {
			return _supportsComet;
		},

		processResponse: _processResponse,

		resume: function() {
			_suspended = false;

			_createRequestTimer();
		},

		setDelay: function(delay) {
			_requestDelay = delay / 1000;
		},

		setEncryptedUserId: function(encryptedUserId) {
			_encryptedUserId = encryptedUserId;
		},

		setSupportsComet: function(supportsComet) {
			_supportsComet = supportsComet;
		},

		setUrl: function(url) {
			_url = url;
		},

		submitRequest: function(key, data, chunkId) {
			for (var i in data) {
				var content = data[i];

				if (content.replace) {
					content = content.replace(_openCurlyBrace, _escapedOpenCurlyBrace);
					content = content.replace(_closeCurlyBrace, _escapedCloseCurlyBrace);

					data[i] = content;
				}
			}

			var requestData = {
				portletId: key,
				data: data
			};

			if (chunkId) {
				requestData.chunkId = chunkId;
			}

			_sendQueue.push(requestData);

			_send();
		},

		suspend: function() {
			_cancelRequestTimer();

			_suspended = true;
		}
	};

	jQuery(document).bind(
		'focus focusin',
		function(event) {
			_metaData.startPolling = true;

			_createRequestTimer();
		}
	);

	Liferay.Poller = Poller;
})();