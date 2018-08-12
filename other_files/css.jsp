
















/*
 ---------- Uni-Form form controls ----------
Uni-Form (v1.1) by Dragan Babic  - http://dnevnikeklektika.com/uni-form/

Modified to use the Liferay/JSR-168 classname convention
Regex used to convert classnames are
Find: (\.|#)([a-z]+)([A-Z]{1})([a-z]+)(\s|\{|:|,)
Replace: $1$2-\L$3$4$5

Distributed under http://creativecommons.org/licenses/by-sa/2.5/
*/

.uni-form {
	margin: 0;
	overflow: hidden;
	padding: 0;
	position: relative;
	width: 100%;
}

/* Some generals */

.uni-form .ctrl-holder {
	/* this is the main unit that contains our form elements */
	overflow: hidden;
	clear: both;
	margin: 0;
	padding: 0;
}

.uni-form .button-holder {
	clear: both;
	overflow: hidden;
}

.uni-form .reset-button {
}

.uni-form .submit-button {
}

.uni-form .inline-label,   .uni-form .inline-labels .inline-label,   .uni-form .block-labels .inline-label {
	display: inline;
	float: none;
	margin: 0 1em 0 0;
	width: auto;
}

.uni-form .inline-label input {
}

.uni-form .focused {
}

/* ########################################################################## */
/* Styles for form controls where labels are in line with the input elements */
/* Set the class of the parent (preferably to a fieldset) to .inline-labels */
.uni-form .inline-labels .ctrl-holder {
}

.uni-form .inline-labels label,   .uni-form .inline-labels .label {
	float: left;
	line-height: 100%;
	margin: .3em 2% 0 0;
	padding: 0;
	position: relative;
}

.uni-form .inline-labels .text-input,   .uni-form .inline-labels .file-upload {
	float: left;
}

.uni-form .inline-labels .file-upload {
}

.uni-form .inline-labels .select-input {
	float: left;
}

.uni-form .inline-labels textarea {
	float: left;
}

.uni-form .inline-labels .form-hint {
	clear: both;
}

/* inlineLabels esthetics */
.uni-form .inline-labels .form-hint strong {
}

/* ########################################################################## */
/* Styles for form controls where labels are above the input elements */
/* Set the class of the parent (preferably to a fieldset) to .block-labels */
.uni-form .block-labels .ctrl-holder {
}

.uni-form .block-labels label,   .uni-form .block-labels .label {
	display: block;
	float: none;
	line-height: 100%;
	margin: .3em 0;
	padding: 0;
	width: auto;
}

.uni-form .block-labels .label {
	float: left;
	margin-right: 3em;
}

.uni-form .block-labels .inline-label {
	position: relative;
	top: .15em;
}

.uni-form .block-labels .text-input,   .uni-form .block-labels .file-upload {
	float: left;
}

.uni-form .block-labels .file-upload {
}

.uni-form .block-labels .select-input {
	display: block;
}

.uni-form .block-labels textarea {
	display: block;
	float: left;
}

.uni-form .block-labels .form-hint {
	clear: none;
	float: right;
	margin: 0;
}

/* blockLabels esthetics */
.uni-form .block-labels .ctrl-holder {
}

.uni-form .block-labels .focused {
}

/* ########################################################################## */
/* Focus pseudoclasses */
.uni-form .ctrl-holder .text-input:focus {
}

.uni-form div.focused .text-input:focus {
}

.uni-form div.focused .form-hint {
}

/* Required fields asterisk styling, use if needed */
.uni-form label em,   .uni-form .label em {
	display: block;
	font-style: normal;
	font-weight: bold;
	left: 100%;
	position: absolute;
}

.uni-form .block-labels label em,   .uni-form .block-labels .label em {
	display: inline;
	position: static;
}

/* ########################################################################## */
/* Messages */
.uni-form #error-msg,   .uni-form .error {
}

.uni-form #error-msg dt,   .uni-form #error-msg h3 {
}

.uni-form #error-msg dd {
}

.uni-form #error-msg ol {
}

.uni-form #error-msg ol li {
}

.uni-form .error-field {
}

/* ########################################################################## */
/* Add the following classes to your fieldsets (preferably) if you want columns */
.uni-form .col {
	float: left;
}

.uni-form .column-left {
	float: left;
}

.uni-form .column-right {
	float: right;
}

/* ---------- IE Specific controls ---------- */



.ie6 .block-labels .form-hint {
	margin-top: 0;
}

/* ---------- Uni-Form custom rules ---------- */
/* Your styles below */
/* Keep in mind that wherever you see "Required property" it means that the property must exist, adjust it's value to your liking */
/* Generals */
.uni-form fieldset {
	margin: 0;
}

.uni-form fieldset legend {
	/* reset ie */
	font-weight: bold;
	color: #000;
	font-size: 120%;
}

.uni-form .ctrl-holder {
	/* this is the main unit that contains our form elements */
	padding: 3px;
}

.uni-form .button-holder {
	text-align: left;
	margin-top: 15px;
}

.uni-form .ctrl-holder .button-holder {
	clear: none;
	margin-left: 5px;
	margin-right: 5px;
	margin-top: 0;
}

.uni-form .focused {
	background: #FFFCDF;
}

.uni-form .ctrl-holder.inline-label label {
	display: inline;
}

/* .inline-labels */
.uni-form .inline-labels label,  .uni-form .inline-labels .label {
	width: 45%;
}

.uni-form .inline-labels .text-input,  .uni-form .inline-labels .file-upload {
	width: 45%;
}

.uni-form .inline-labels .select-input {
	width: 45%;
}

.uni-form .inline-labels textarea {
	height: 12em; /* required property */
	width: 45%;
}

.uni-form .inline-labels .form-hint {
	margin-left: 47%;
	margin-top: 0;
}

/* .block-labels */
.uni-form .block-labels .text-input,  .uni-form .block-labels .file-upload {
	width: 53%;
}

.uni-form .block-labels .select-input {
	display: block;
	width: 53.5%;
}

.uni-form .block-labels textarea {
	/* required property */
	height: 12em;
	width: 53%;
}

.uni-form .block-labels .form-hint {
	width: 45%;
}

/* Columns */
.uni-form .col {
	margin: 0 2% 0 0; /* required property */
	width: 47.9%;
}

.uni-form .column-left {
	width: 49%;
}

.uni-form .column-right {
	width: 49%;
}

/* Messages */
.uni-form #error-msg {
	background: #FFDFDF;
	border: 1px solid #DF7D7D;
	border-width: 1px 0;
	margin: 0 0 1em 0;
	padding: 1em;
}

.uni-form .error {
	background: #FFDFDF;
	border: 1px solid #DF7D7D;
	border-width: 1px 0;
}

.uni-form #error-msg dt,  .uni-form #error-msg h3 {
	font-size: 110%;
	font-weight: bold;
	line-height: 100%;
	margin: 0 0 .5em 0;
}

.uni-form #error-msg dd {
	margin: 0;
	padding: 0;
}

.uni-form #error-msg ol {
	margin: 0;
	padding: 0;
}

.uni-form #error-msg ol li {
	border-bottom: 1px dotted #DF7D7D;
	list-style-position: inside;
	margin: 0;
	padding: 2px;
	position: relative;
}

.uni-form .error-field {
	background: #FFBFBF;
	color: #AF4C4C;
	margin: 0 0 6px 0;
	padding: 4px;
}

/* ---------- Modules ---------- */

/* ---------- Generic module styling ---------- */

.lfr-grid {
	width: 100%;
}

.lfr-component, .lfr-component ul, .lfr-component li, .lfr-component dl, .lfr-component dt, .lfr-component dd {
	margin: 0;
	padding: 0;
	list-style: none;
}

.lfr-component li img, img.icon {
	vertical-align: middle;
    min-width: 16px;
}

#layout-grid.dragging .lfr-portlet-column.empty {
	padding: 20px;
}

.lfr-js-required {
	position: absolute;
	left: -9999em;
	top: -9999em;
}

.js .lfr-js-required {
	position: static;
}

/* ---------- Add content styles ---------- */

.portal-add-content-search {
	margin-bottom: 8px;
}

.portal-add-content .lfr-portlet-used {
	color: #ccc;
	cursor: default;
}

.portal-add-content .portlet-msg-info {
	color: #333;
	margin-bottom: 0;
	margin-top: 10px;
}

.portal-add-content .lfr-portlet-used a {
	display: none;
}

.lfr-add-content {
	margin-bottom: 0.5em;
}

.lfr-add-content.collapsed {
}

.lfr-add-content.expanded {
}

.lfr-add-content h2 {
	cursor: pointer;
	font-size: 1.1em;
	font-weight: bold;
	margin: 0;
}

.lfr-add-content.collapsed h2, .lfr-add-content .lfr-add-content.collapsed h2 {
	background: url(/looking-glass-student-theme/images/arrows/01_plus.png) no-repeat 100% 50%;
	border: none;
}

.lfr-add-content.expanded h2, .lfr-add-content .lfr-add-content.expanded h2 {
	background: url(/looking-glass-student-theme/images/arrows/01_minus.png) no-repeat 100% 50%;
}

.lfr-add-content h2 span {
	background: url(/looking-glass-student-theme/images/add_content/portlet_category.png) no-repeat 0 50%;
	padding-left: 20px;
}

.lfr-install-more {
	border-top: 1px solid #ccc;
	margin: 10px 0 0;
	padding-top: 10px;
}

.lfr-install-more a {
	background: url(/looking-glass-student-theme/images/common/install_more.png) no-repeat 0 50%;
	display: block;
	font-weight: bold;
	padding-left: 20px;
}

.lfr-content-category {
	padding-left: 10px;
	padding-top: 3px;
}

.lfr-content-category.hidden {
	display: none;
}

.lfr-content-category.visible {
	border-bottom: 1px solid #ddd;
	border-top: 1px solid #ddd;
	display: block;
}

.ie6 .lfr-content-category.visible {
	height: 1%;
}

.lfr-has-sidebar {
	padding-left: 270px;
}

/* ---------- Flyout ---------- */

.lfr-flyout ul {
	display: none;
}

.js li.lfr-flyout {
	display: block;
	position: relative;
}

.js .lfr-flyout li ul {
	display: none;
}

.js .lfr-flyout.has-children {
	background: url(/looking-glass-student-theme/images/arrows/04_left.png) no-repeat 5px 50%;
	padding-left: 12px;
}

.js .lfr-flyout.has-children.send-right {
	background-image: url(/looking-glass-student-theme/images/arrows/04_right.png);
}

.js .lfr-flyout.has-children ul {
	display: none;
	min-width: 150px;
	position: absolute;
	right: 100%;
	top: -1px;
}

.js .lfr-flyout.has-children.send-right ul {
	left: 100%;
	right: auto;
}

/* ---------- Panel component ---------- */

.lfr-panel.lfr-extended, .lfr-panel-container, .lfr-floating-container {
	border: 1px solid;
	border-color: #DEDEDE #BFBFBF #BFBFBF #DEDEDE;
}

.lfr-panel-container, .lfr-floating-container {
	background: #fff;
	clear: both;
}

.lfr-floating-container {
	position: relative;
}

.lfr-panel-container .lfr-panel {
	border: none;
}

.lfr-panel .lfr-panel-titlebar {
	margin-bottom: 0.5em;
	overflow: hidden;
}

.lfr-panel.lfr-collapsible .lfr-panel-titlebar {
	background: url(/looking-glass-student-theme/images/arrows/05_down.png) no-repeat 2px 50%;
	cursor: pointer;
	padding-left: 15px;
}

.lfr-panel-titlebar .lfr-panel-title {
	float: left;
	font-size: 1.2em;
	font-weight: bold;
	margin: 0;
}

.lfr-panel-titlebar .lfr-panel-button {
	background: url(/looking-glass-student-theme/images/application/panel_header_toggler_close.png) no-repeat 0 0;
	display: none;
	float: right;
	height: 22px;
	width: 19px;
}

.lfr-extended.lfr-collapsible .lfr-panel-button {
	display: block;
}

.lfr-panel.lfr-collapsed .lfr-panel-titlebar .lfr-panel-button {
	background-image: url(/looking-glass-student-theme/images/application/panel_header_toggler_open.png);
}

.lfr-panel-titlebar .lfr-panel-button:hover {
	background-position: 0 100%;
}

.lfr-panel.lfr-collapsed .lfr-panel-titlebar {
	background-image: url(/looking-glass-student-theme/images/arrows/05_right.png);
	margin-bottom: 0;
}

.lfr-panel.lfr-extended .lfr-panel-titlebar {
	background: #d6d6d6 url(/looking-glass-student-theme/images/application/panel_header.png) repeat-x 0 0;
	border-bottom: 1px solid #cdcdcd;
	line-height: 1.6;
	padding: 2px;
}

.ie6 .lfr-extended.lfr-collapsible .lfr-panel-titlebar {
	height: 1%;
}

.lfr-extended.lfr-collapsed .lfr-panel-titlebar {
	border-bottom: none;
}

.lfr-panel-container .lfr-extended.lfr-collapsible .lfr-panel-titlebar {
	border-top: 1px solid #cecece;
}

.lfr-panel.lfr-collapsed .lfr-panel-content {
	display: none;
}

.js .lfr-floating-container {
	display: none;
	position: absolute;
}

.js .lfr-floating-trigger {
	background-image: url(/looking-glass-student-theme/images/arrows/05_down.png);
	background-position: 100% 50%;
	background-repeat: no-repeat;
	padding: 3px;
	padding-right: 15px;
	text-decoration: none;
}

.js .lfr-trigger-selected {
	background-color: #069;
	color: #fff;
}

.js #wrapper .lfr-trigger-selected {
	background-color: #069;
	color: #fff;
}



.lfr-floating-container .col {
	float: left;
	margin-right: 10px;
	width: auto;
}

.lfr-floating-container .lfr-form-row {
	border: none;
}

.lfr-panel .lfr-panel-content .undo-queue {
	border-left: none;
	border-right: none;
	border-top: none;
	margin: -0.5em 0 10px;
}

/* ---------- Panel pagination ---------- */

.js .lfr-panel-paging .lfr-panel-content ul {
	display: none;
}

.lfr-paging-container {
	background: #cfd2d5;
	border-bottom: 1px solid #dcdee0;
	border-top: 1px solid #dcdee0;
	text-align: center;
}

.lfr-panel-content .lfr-paging-container li {
	display: inline;
}



.js .lfr-panel-paging .lfr-panel-content .current-set, .js .lfr-panel-paging .lfr-paging-container ul {
	display: block;
	position: relative;
	visibility: visible;
    padding: 0 4px 4px 6px;
}

.js .lfr-panel-paging .lfr-paging-container ul {
	padding-top: 1px;
}

.lfr-panel-content .lfr-paging-container li a {
	background: none;
	border: 1px solid #CFD2D5;
	display: inline-block;
	float: none;
	padding: 5px 10px;
	text-align: center;
	width: auto;
}

.lfr-panel-content .lfr-paging-container li a:hover {
	background: #5094d7 url(/looking-glass-student-theme/images/application/current_page_bg.png) repeat-x 0 0;
	border-color: #31659c #396ea8 #4c8ccb;
	color: #fff;
	font-weight: bold;
}

.lfr-panel-content .lfr-paging-container li.lfr-page-current a {
	background: #99a7b3 url(/looking-glass-student-theme/images/application/current_page_hover_bg.png) repeat-x 0 0;
	border-color: #6b7785 #7c8994 #919fa9;
	color: #fff;
	font-weight: bold;
}

.lfr-panel-content .lfr-paging-container {
	overflow: hidden;
}

.ie6 .lfr-panel-content .lfr-paging-container {
	height: 1%;
}

/* ---------- Position helper ---------- */

.lfr-position-helper {
	position: absolute;
	z-index: 1000;
}


/* ---------- Auto row styles ---------- */

.lfr-form-row {
	border-bottom: 1px solid #CCC;
	overflow: hidden;
	padding: 5px;
	position: relative;
	margin-bottom: 10px;
}

.lfr-form-row .row-controls {
	bottom: 5px;
	float: right;
	position: absolute;
	right: 5px;
}

.lfr-form-row .row-controls a {
	background: url() no-repeat 2px 50%;
	display: block;
	float: left;
	font-size: 0;
	height: 16px;
	padding: 2px;
	text-indent: -9999em;
	width: 16px;
}

.lfr-form-row .row-controls .add-row {
	background-image: url(/looking-glass-student-theme/images/common/add.png);
}

.lfr-form-row .row-controls .delete-row {
	background-image: url(/looking-glass-student-theme/images/common/delete.png);
}

.lfr-form-row legend .field-label{
	float:left;
	margin-right: 10px;
}

.lfr-form-row .lfr-arrow-controls a {
	background: url() no-repeat 2px 50%;
	clear: none;
	display: block;
	float: left;
	font-size: 0;
	height: 16px;
	padding: 2px;
	text-indent: -9999em;
	width: 16px;
}

.lfr-form-row .handle-sort-vertical {
	background: url(/looking-glass-student-theme/images/application/handle_sort_vertical.png) no-repeat 0 50%;
	cursor: move;
	padding-left: 20px;
}

.uni-form .lfr-form-row fieldset {
	border: none;
	margin: 0;
	padding: 0;
}

/* ---------- Undo manager ---------- */

.undo-queue.queue-empty {
	display: none;
}

.ie6 .undo-queue.queue-empty {
	display: none;
}

.undo-queue .undo-action {
	float: left;
}

.undo-queue .clear-undos {
	float: right;
}

.undo-queue.queue-single .clear-undos {
	display: none;
}

.portlet-msg-info.undo-queue {
	overflow: hidden;
	margin: 10px auto;
}



/* ---------- Panel Page styles ---------- */

.lfr-panel-page .portal-add-content {
	padding: 0;
	padding-left: 4px;
}

.lfr-panel-page .panel-page-content {
	border-left: 1px solid #ccc;
	padding-left: 1em;
}

.lfr-panel-page .lfr-add-content h2 {
	border: 1px solid #ccc;
	border-right: none;
	padding: 1px;
}

.lfr-panel-page .lfr-add-content h2 span {
	background: #efefef;
	display: block;
	padding: 2px;
	padding-left: 5px;
}

.lfr-panel-page .lfr-add-content .lfr-content-category h2 {
	border: none;
	border-bottom: 1px solid #ccc;
}

.lfr-panel-page .lfr-add-content .lfr-content-category h2 span {
	background: none;
}

.lfr-panel-page.panel-page-frontpage .panel-page-content h2 {
	margin-top: 0;
}

/* ---------- Javascript template styles ---------- */

.lfr-template {
	display: none;
}

/* ---------- Portlet item ---------- */

.lfr-portlet-item {
	background: url(/looking-glass-student-theme/images/add_content/portlet_item.png) no-repeat 0 50%;
	border: 1px solid #fff;
	cursor: move;
	font-size: 1.1em;
	margin-bottom: 3px;
	padding: 0 5px 0 20px;
}

.lfr-portlet-item.lfr-instanceable {
	background-image: url(/looking-glass-student-theme/images/add_content/portlet_item_instanceable.png);
}

.lfr-portlet-item:hover, .lfr-portlet-item.over {
	background-color: #ffc;
	border-color: #fc0;
}

.ie .lfr-portlet-item {
	/* height: 1%; */
}

.lfr-portlet-item p {
	font-size: 1em;
	margin: 0;
	padding-right: 30px;
	position: relative;
}

.lfr-portlet-item p a {
	cursor: pointer;
	font-size: 0.9em;
	font-weight: bold;
	position: absolute;
	right: 0;
	top: 0;
}

.ie .lfr-portlet-item p a {
	top: -2px;
}

.ie6 .lfr-portlet-item p a {
	right: 20px;
}

#layout_configuration_content {
	width: 95%;
}

/* ---------- Interactive Dock ---------- */

.js .interactive-mode {
	float: right;
	min-width: 150px;
	position: absolute;
	right: 10px;
	top: 10px;
}

.js .interactive-mode h2 {
	background: url(/looking-glass-student-theme/images/dock/menu_bar.png) no-repeat 100% -30px;
	font-size: 1.2em;
	margin-bottom: 0;
	padding: 0 29px 0 0;
	position: relative;
	z-index: 82;
}

.js .interactive-mode h2 span {
	background: url(/looking-glass-student-theme/images/dock/menu_bar.png) no-repeat 0 0;
	display: block;
	font-size: 1.2em;
	margin-bottom: 0;
	min-height: 16px;
	min-width: 90px;
	padding: 0.5em 0.5em 0.5em 2em;
}

.js.ie6 .interactive-mode h2 span {
	height: 16px;
}

.js .lfr-dock.expanded .lfr-dock-list-container {
	border-top: none;
	top: -2px;
}

.js .interactive-mode ul {
	background: url(/looking-glass-student-theme/images/dock/menu_bg.png) no-repeat 0 0;
	display: none;
	float: none;
}

.js .interactive-mode li {
	display: block;
	float: none;
	margin-bottom: 0pt;
	margin-left: 0.2em;
}

.js .interactive-mode li a {
	background-position: 0.5em 50%;
	background-repeat: no-repeat;
	display: block;
	margin-left: 0.3em;
	padding: 0.5em 0pt 0.5em 2.5em;
	text-decoration: none;
}

.js .interactive-mode li a:hover {
	background-position: 1.5em 50%;
	padding-left: 3.5em;
}

.js .interactive-mode .my-places li.current a {
	background: transparent url(/looking-glass-student-theme/images/dock/my_place_current.png) no-repeat 1em 50%;
	margin: 0.1em 0 0 0.2em;
	padding-left: 3.5em;
}

.js .interactive-mode .lfr-flyout.has-children li {
	position: relative;
}

.js .interactive-mode .my-places li.public a {
	background-image: url(/looking-glass-student-theme/images/dock/my_places_public.png);
}

.js .interactive-mode .my-places li.private a {
	background-image: url(/looking-glass-student-theme/images/dock/my_places_private.png);
}

.js .interactive-mode .my-places ul li a.add-page {
	background: url(/looking-glass-student-theme/images/dock/page_settings.png) no-repeat;
	border: none;
	display: block;
	font-size: 0;
	height: 16px;
	padding: 0;
	position: absolute;
	right: 3px;
	text-indent: -9999em;
	top: 3px;
	width: 16px;
}

.ie6.js .lfr-dock.interactive-mode {
	white-space: nowrap;
	width: 150px;
}

.ie6.js .lfr-dock.interactive-mode li {
	height: 1%;
}

.ie6.js .lfr-dock.interactive-mode li a {
	height: 1%;
}

/* ---------- Portlet css editor ---------- */

#portlet-set-properties {
	display: none;
}

#portlet-set-properties .uni-form {
	clear: both;
}

#portlet-set-properties fieldset {
	margin-bottom: 1em;
}

#portlet-set-properties fieldset fieldset {
	margin-top: 1em;
}

#portlet-set-properties fieldset fieldset legend {
	font-size: 1.1em;
}

#portlet-set-properties .uni-form .text-input {
	margin-right: 5px;
	width: 80px;
}

#portlet-set-properties .uni-form fieldset.col {
	width: 29%;
}

#portlet-set-properties .common {
	width: 27%;
}

#portlet-set-properties .extra {
	width: 20%;
}

#portlet-set-properties #lfr-border-width, #portlet-set-properties #lfr-border-style, #portlet-set-properties #lfr-border-color {
	float: left;
}

#portlet-set-properties #lfr-border-width {
	width: 25%;
}

#portlet-set-properties #lfr-border-style {
	width: 15%;
}

#portlet-set-properties #lfr-border-color {
	width: 20%;
}

#portlet-set-properties #lfr-padding, #portlet-set-properties #lfr-margin {
	width: 25%;
}

#portlet-set-properties .uni-form #custom-css {
	height: 300px;
	width: 400px;
}

#portlet-set-properties .form-hint {
	float: none;
}

#portlet-set-properties .lfr-bg-image-properties {
	display: none;
}

#portlet-set-properties #border-note {
	display: none;
	margin-top: 10px;
}

#portlet-set-properties .uni-form {
	clear: both;
}

/* ---------- Toolbar ---------- */

.lfr-toolbar {
	background-color: #e5e4e8;
	padding-top: 3px;
}

.lfr-toolbar:after {
	clear: both;
	content: ".";
	display: block;
	height: 0;
	visibility: hidden;
}

.ie .lfr-toolbar {
	height: 1%;
}

.ie6 .lfr-toolbar {
	width: 750px;
}

.lfr-toolbar .lfr-button, .lfr-emoticon-container .lfr-button {
	border: 1px solid #e5e4e8;
	cursor: pointer;
	margin: 0 2px;
	padding: 2px 4px;
}

.lfr-toolbar .lfr-button img {
	vertical-align: text-top;
}

.lfr-toolbar .lfr-button:focus {
	border: 1px solid #000;


}

.lfr-toolbar .lfr-button:hover {
	border-bottom-color: #777;
	border-right-color: #777;
	border: 1px solid #ccc;
}

.lfr-toolbar .lfr-separator {
	border-left: 1px solid #fff;
	border-right: 1px solid #ccc;
	font-size: 12px;
	height: 25px;
	margin: 0 5px;
}

.lfr-toolbar select, .lfr-toolbar .lfr-button, .lfr-toolbar .lfr-separator, .lfr-emoticon-container .lfr-button {
	float: left;
}

.lfr-toolbar select {
	margin: 0 5px;
}

.ie .lfr-toolbar select {
	margin-top: 3px;
}

.lfr-emoticon-container {
	background: #e5e4e8;
	border: 1px solid #ccc;
	display: none;
	padding-top: 5px;
	position: absolute;
	width: 180px;
}

.lfr-emoticon-container .lfr-button {
	margin: 0;
}

/* ---------- Tree ---------- */

.lfr-tree {
}

.lfr-tree .expand-image {
}

.lfr-tree a {
	text-decoration: none;
}

.lfr-tree li {
	margin-bottom: 2px;
	padding-left: 0;
}

.lfr-tree li ul {
}

.lfr-tree li ul li, .lfr-tree li.tree-item {
	padding-left: 0;
}

.lfr-tree img {
	vertical-align: middle;
}

.lfr-tree li.tree-item {
	padding-left: 5px;
}

.lfr-tree li.tree-item a img {
	cursor: move;
}

.lfr-tree li.tree-item li {
	padding-left: 20px;
}

.lfr-tree li.tree-item ul {
	margin-left: 0;
	margin-top: 5px;
}

.lfr-tree li.tree-item a, .lfr-tree li.tree-item .expand-image {
	cursor: pointer;
}

.lfr-tree .tree-item-hover {
	background: #7D93C1;
	padding: 5px;
}

li.toggle-expand {
	padding-bottom: 10px;
}

li.toggle-expand a {
	padding: 2px 0 2px 20px;
}

.lfr-expand {
	background: url(/looking-glass-student-theme/images/trees/expand_all.png) no-repeat 0 50%;
}

.lfr-collapse {
	background: url(/looking-glass-student-theme/images/trees/collapse_all.png) no-repeat 0 50%;
}

/* ---------- Uploader ---------- */

.lfr-upload-container {
	margin-bottom: 1em;
	width: 450px;
}

.lfr-upload-container .upload-target a {
	float: left;
	margin-right: 15px;
}

.lfr-upload-container a.browse-button {
	background-image: url(/looking-glass-student-theme/images/dock/add_content.png);
	background-repeat: no-repeat;
}

.lfr-upload-container a.upload-button {
	background-image: url(/looking-glass-student-theme/images/common/top.png);
	background-repeat: no-repeat;
}

.lfr-upload-container a.clear-uploads {
	background-image: url(/looking-glass-student-theme/images/portlet/refresh.png);
	background-repeat: no-repeat;
}

.lfr-upload-container a.cancel-uploads {
	background-image: url(/looking-glass-student-theme/images/common/close.png);
	background-repeat: no-repeat;
	float: right;
	margin-right: 0;
}

.lfr-upload-container .upload-file {
	background: #f0faf0 url(/looking-glass-student-theme/images/document_library/jpg.png) no-repeat 5px 50%;
	border-bottom: 1px solid #ccc;
	display: block;
	font-weight: bold;
	margin-bottom: 1px;
	padding: 5px;
	padding-left: 25px;
	position: relative;
}

.lfr-upload-container .upload-list-info {
	margin: 5px 0;
}

.lfr-upload-container .upload-list-info h4 {
	font-size: 1.3em;
}

.lfr-upload-container .cancel-button {
	background-image: url(/looking-glass-student-theme/images/common/delete.png);
	background-repeat: no-repeat;
	position: absolute;
	right: 5px;
}

.lfr-upload-container .upload-complete {
	background-color: #E8EEF7;
	background-image: url(/looking-glass-student-theme/images/dock/my_place_current.png);
	font-weight: normal;
	opacity: 0.6;
}

.lfr-upload-container .upload-complete .cancel-button {
	display: none;
}

.lfr-upload-container .file-uploading {
	background-color: #ffc;
}

.lfr-upload-container .file-uploading .cancel-button {
	top: 0;
}

.lfr-upload-container .progress-bar {
	background: #fff;
	border: 1px solid #83a8d9;
	display: none;
	height: 15px;
}

.lfr-upload-container .progress {
	background: #8db2e3 url(/looking-glass-student-theme/images/progress_bar/complete_gradient.png) repeat-y 100% 0;
	display: block;
	height: 15px;
	width: 0;
}

.lfr-upload-container .file-uploading .progress-bar {
	display: block;
}

/* ---------- Portal ---------- */

/* ---------- Page settings styling ---------- */

.page-extra-settings .lfr-panel-titlebar .lfr-panel-title {
	font-size: 1em;
	padding: 0.5em 0;
}

.page-extra-settings .lfr-extended .lfr-panel-titlebar {
	line-height: 1;
}

.page-extra-settings .lfr-extended .lfr-panel-titlebar {
	line-height: 1;
}

.page-extra-settings .lfr-extended .lfr-panel-content {
	padding: 5px;
}

/* ---------- Portal notifications styling ---------- */

.popup-alert-notice .notice-date {
	margin: 0 10px;
}

.popup-alert-notice .current-user-language {
	border: 1px solid #ccc;
	border-bottom: none;
	border-top: none;
	display: inline;
	margin: 0 10px;
	padding: 0 15px;
}

/* ---------- Tag selector styling ---------- */

.ui-dialog.lfr-tag-selector .ui-dialog-container .ui-dialog-content {
	padding: 0;
}

.lfr-tag-container {
	height: 260px;
	margin-bottom: 0.5em;
	overflow: auto;
}

.lfr-tag-container fieldset {
	margin: 5px;
}

.lfr-tag-container legend {
	font-weight: bold;
	margin-left: 5px;
}

.lfr-tag-container label {
	display: block;
}

.lfr-tag-container label input {
	vertical-align: middle;
}

.lfr-tag-container .lfr-tag-message {
	display: none;
}

.lfr-tag-search-container {
	background-color: #D3DADD;
	border-bottom: 1px solid #AEB8BC;
	margin: 3px 0;
	padding: 5px;
}

.lfr-tag-search-input {
	width: 250px;
}

.lfr-tag-container .no-matches {
	border-bottom: none;
	border-left: none;
	border-right: none;
	color: #999;
	margin-bottom: 0;
	margin-left: 0;
	margin-top: 0;
	padding: 0;
}

.lfr-tag-container .no-matches legend {
	padding-left: 0;
}

.lfr-tag-container .no-matches .lfr-tag-message {
	display: block;
}

/* ---------- Generic styling ---------- */

.popup-alert-notice, .popup-alert-warning {
	background: #ffc url() no-repeat 5px 50%;
	border-bottom: 1px solid;
	font-size: 1.1em;
	left: 0;
	padding: 10px;
	padding-left: 25px;
	position: fixed;
	top: 0;
	width: 100%;
	z-index: 10000;
}

.popup-alert-notice {
	background-color: #ffc;
	background-image: url(/looking-glass-student-theme/images/messages/alert.png);
	border-bottom-color: #fc0;
}

.popup-alert-warning {
	background-color: #fcc;
	background-image: url(/looking-glass-student-theme/images/messages/error.png);
	border-bottom-color: #f00;
	font-weight: bold;
}

/*.ie6 .popup-alert-notice, .ie6 .popup-alert-warning {
	bottom: auto;
	left: expression( ( LFR_IGNORE_ME2 = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft ) + 'px' );
	position: absolute;
	right: auto;
	top: expression( ( LFR_IGNORE_ME = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) + 'px' );
}*/

.popup-alert-notice .countdown-timer {
	font-size: 1.1em;
	font-weight: bold;
}

.popup-alert-notice input, .popup-alert-warning input {
	vertical-align: middle;
}

#ui-datepicker-div {
	z-index: 500;
}

/* ---------- Portlets ---------- */

/* ---------- Generic styling ---------- */

.breadcrumbs {
	margin-bottom: 10px;
	margin-left: 0px;
}

.js .lfr-fallback {
	display: none;
}

.lfr-button {
	background: url() no-repeat 0 50%;
	padding: 2px 0 2px 20px;
}

.js .controls-hidden .lfr-meta-actions, .js .controls-hidden .portlet-borderless-bar, .js .controls-hidden .lfr-configurator-visibility {
	display: none;
}

.js .page-maximized .portlet-icons {
	display: block;
}

.float-container:after {
	clear: both;
	content: ".";
	display: block;
	height: 0;
	visibility: hidden;
}

.ie .float-container {
	height: 1%;
}

.lfr-meta-actions {
	padding-top: 1em;
}

.lfr-table {
	border-collapse: collapse;
	clear: both;
}

.lfr-table tr td, .lfr-table tr th {
	padding: 0 5px;
}

.lfr-table tr th {
	font-weight: bold;
}

.lfr-table tr td:first-child, .lfr-table tr td.first-child, .lfr-table tr th:first-child, .lfr-table tr th.first-child {
	padding-left: 0;
    vertical-align:top;
}

.lfr-table tr td:last-child, .lfr-table tr td.last-child, .lfr-table tr th:last-child, .lfr-table tr th.last-child {
	padding-right: 0;
}

.lfr-control-links a {
	margin-right: 1em;
}

.portlet-toolbar {
	margin-bottom: 1.5em;
}

.portlet-minimized .portlet-content-container {
	display: none;
}

.lfr-checkbox-preselected {
	opacity: 0.5;
}



.lfr-configurator-visibility {
	opacity: 0.5;
}

/* ---------- Liferay forms ---------- */

.lfr-input-text {
	width: 350px;
}

.lfr-input-text.flexible {
	width: auto;
}

.lfr-textarea {
	height: 100px;
	width: 500px;
}

fieldset, .uni-form fieldset {
	margin-bottom: 2em;
}

fieldset:last-child, .uni-form fieldset:last-child {
	margin-bottom: 0;
}

/* ---------- Separator ---------- */

.separator {
	margin: 15px auto;
}

/* ---------- Taglib action bar ---------- */

.lfr-actions {
	float: right;
	text-align: left;
}

.lfr-actions.left {
	float: left;
}

.lfr-actions ul {
	display: none;
	bottom: 0%;
	position: absolute;
	right: 100%;
	z-index: 99999;
}

.lfr-actions.visible ul {
	display: block;
}

.lfr-actions.left ul {
	right: auto;
	left: 100%;
}

.lfr-actions .lfr-trigger, .lfr-actions .lfr-trigger strong {
	background: url(/looking-glass-student-theme/images/common/button_bg.png) no-repeat;
	font-weight: normal;
}

.lfr-actions .lfr-trigger {
	background-position: 100% -42px;
	cursor: pointer;
	padding-right: 3px;
}

.ie6 .lfr-actions {
	height: 15px;
}

.lfr-actions .lfr-trigger strong {
	display: block;
	min-width: 70px;
	padding: 2px 0 3px;
	text-align: center;
}

.ie6 .lfr-actions .lfr-trigger strong {
	display: inline-block;
}

.lfr-actions.visible .lfr-trigger {
	background-position: 100% 100%;
}

.lfr-actions.visible .lfr-trigger strong {
	background-position: 0 -21px;
}

.lfr-actions .lfr-trigger strong span {
	background: url(/looking-glass-student-theme/images/common/action.png) no-repeat 5px 50%;
	padding: 2px 10px 2px 35px;
}

.lfr-actions.left .lfr-trigger strong span {
	background-image: url(/looking-glass-student-theme/images/common/action_right.png);
	background-position: 98% 50%;
	padding: 2px 35px 2px 10px;
}

.lfr-menu-list ul {
	background: #fff url(/looking-glass-student-theme/images/forms/button.png) repeat-x 0 100%;
	border: 1px solid;
	border-color: #DEDEDE #BFBFBF #BFBFBF #DEDEDE;
}

.lfr-menu-list li {
	background: transparent;
	border-bottom: 1px solid #DEDEDE;
	padding: 2px;
}

.lfr-menu-list li nobr {
	display: block;
}

.lfr-menu-list li a {
	padding: 5px 10px 5px 0;
	display: block;
	font-weight: normal;
	text-decoration: none;
}

.lfr-menu-list li a:hover {
	background-color: #828F95;
	color: #fff;
}

.lfr-menu-list li a img {
	padding: 0 3px;
}

.lfr-menu-list li.last {
	border-bottom: none;
}

/* ---------- Taglib calendar ---------- */

.taglib-calendar {
	width: 190px;
}

.taglib-calendar table {
	border: 1px solid #999;
	width: 100%;
}

.taglib-calendar tr th, .taglib-calendar tr td {
	height: 25px;
	text-align: center;
	border-bottom: 1px solid #999;
}

.taglib-calendar tr.portlet-section-header th, .taglib-calendar tr td {
	border: 1px solid #999;
	border-bottom: none;
	border-top: none;
	padding: 0;
	width: 26px;
}

.taglib-calendar tr.portlet-section-header th.first, .taglib-calendar tr td.first {
	border-left: none;
}

.taglib-calendar tr.portlet-section-header th.last, .taglib-calendar tr td.last {
	border-right: none;
}

.taglib-calendar tr td a {
	display: block;
	height: 15px;
	padding: 5px 0;
}

.taglib-calendar a:hover, .taglib-calendar a:focus {
	background-color: #ccc;
}

.taglib-calendar .calendar-inactive {
	color: #999;
}

.taglib-calendar .calendar-current-day {
}

.taglib-calendar .calendar-current-day a {
}

.taglib-calendar .has-events a span {
	background: url(/looking-glass-student-theme/images/calendar/event_indicator.png) no-repeat 50% 95%;
	padding-bottom: 5px;
}

.taglib-calendar .has-events.calendar-current-day a span {
	background-image: url(/looking-glass-student-theme/images/calendar/event_indicator_current.png);
}

/* ---------- Taglib captcha ---------- */

.taglib-captcha {
	margin: 1em 0;
}

.taglib-captcha .captcha {
	display: block;
	margin-bottom: 1em;
}

/* ---------- Taglib discussion thread ---------- */

.taglib-discussion td img {
	vertical-align: middle;
}

/* ---------- Taglib diff thread ---------- */

.taglib-diff-addedline, #taglib-diff-results ins {
	background: #E6FFE6;
}

.taglib-diff-context {
	background: #EEEEEE;
}

.taglib-diff-deletedline, #taglib-diff-results del {
	background: #FFE6E6;
}

.taglib-diff-table {
	border-collapse: separate;
	border-spacing: 5pt;
	width: 100%;
}

/* ---------- Taglib flags ---------- */

.taglib-flags {
	display: inline-block;
}

.taglib-flags span a {
	margin-right: 2px;
}

/* ---------- Taglib icon list ---------- */

.taglib-icon-list li {
	float: left;
	margin-right: 1em;
}

.taglib-icon-list:after {
	clear: both;
	content: ".";
	display: block;
	height: 0;
	visibility: hidden;
}

.ie .taglib-icon-list {
	height: 1%;
}

/* ---------- Taglib input move boxes ---------- */

.taglib-move-boxes {
}

.taglib-move-boxes .choice-selector {
	min-width: 150px;
}

/*.ie .taglib-move-boxes .choice-selector {
	width: expression(this.currentStyle.getAttribute('minWidth') || 150 + 'px');
}*/

.taglib-move-boxes .category-header {
	background: #ebf1f9;
	border-bottom: 1px solid #8db2f3;
	display: block;
	margin-bottom: 5px;
	padding: 5px;
}

/* ---------- Taglib ratings ---------- */

.taglib-ratings.score {
	white-space: nowrap;
}

.taglib-ratings.thumbs {
	float: left;
	margin: 0;
}

.ie .taglib-ratings.thumbs {
	height: 1%;
}

.taglib-ratings.thumbs:after {
	clear: both;
	content: ".";
	display: block;
	height: 0;
	visibility: hidden;
}

.taglib-ratings.thumbs li {
	float: left;
	list-style-image: none;
	list-style-position: outside;
	list-style-type: none;
}

.taglib-ratings.thumbs .total-entries {
	color: #777777;
}

.taglib-ratings.thumbs .total-rating {
	font-size: 1.1em;
	line-height: 18px;
	padding: 0 5px 0 0;
}

.taglib-ratings.thumbs .total-votes {
	color: #777777;
	font-size: xx-small;
	line-height: 2em;
	padding: 0 0 0 6px;
	text-align: right;
}

.taglib-ratings.thumbs .pos-total {
	color: #009900;
	font-weight: bold;
}

.taglib-ratings.thumbs .neg-total {
	color: #777777;
	font-weight: bold;
}

.taglib-ratings.thumbs .zero-total {
	color: #aaaaaa;
}

.taglib-ratings.thumbs .rating {
	background: url() no-repeat;
	display: block;
	float: left;
	font-size: 0;
	height: 18px;
	line-height: 0;
	text-indent: -9999em;
	width: 18px;
}

.taglib-ratings.thumbs .rate-up {
	background-image: url(/looking-glass-student-theme/images/ratings/thumbs_up_icon.png);
}

.taglib-ratings.thumbs .rate-up:hover, .taglib-ratings.thumbs .rate-up.rated {
	background-image: url(/looking-glass-student-theme/images/ratings/thumbs_up_icon_hover.png);
}

.taglib-ratings.thumbs .rate-down {
	background-image: url(/looking-glass-student-theme/images/ratings/thumbs_down_icon.png);
}

.taglib-ratings.thumbs .rate-down:hover, .taglib-ratings.thumbs .rate-down.rated {
	background-image: url(/looking-glass-student-theme/images/ratings/thumbs_down_icon_hover.png);
}

.taglib-ratings.thumbs .rate-up.rated:hover, .taglib-ratings.thumbs .rate-down.rated:hover {
	background-image: url(/looking-glass-student-theme/images/ratings/thumbs_cancel_icon.png);
}

/* ---------- Taglib search iterator ---------- */

.taglib-search-iterator {
	border-collapse: collapse;
	width: 100%;
}

.taglib-search-iterator td {
	padding: 4px;
}

.taglib-search-iterator-highlighted {
	font-weight: bold;
}

.taglib-search-iterator-page-iterator-top {
	padding-bottom: 5px;
}

.taglib-search-iterator-page-iterator-bottom {
	padding-top: 5px;
}

.taglib-page-iterator {
	clear: both;
	height: auto;
	overflow: hidden;
	width: auto;
}

.taglib-page-iterator .search-results {
	float: left;
}

.taglib-page-iterator .search-pages {
	float: right;
}

.taglib-page-iterator .search-pages .page-links a, .taglib-page-iterator .search-pages .page-links span {
	background: url() no-repeat 0 0;
	border-left: 1px solid #ccc;
	padding: 2px 15px;
}

.taglib-page-iterator .search-pages .page-links span {
	background-position: 0 100%;
}

.taglib-page-iterator .search-pages .page-links a.first, .taglib-page-iterator .search-pages .page-links span.first {
	background-image: url(/looking-glass-student-theme/images/arrows/paging_first.png);
	background-repeat: no-repeat;
	border-left: none;
}

.taglib-page-iterator .search-pages .page-links a.previous, .taglib-page-iterator .search-pages .page-links span.previous {
	background-image: url(/looking-glass-student-theme/images/arrows/paging_previous.png);
	background-repeat: no-repeat;
}

.taglib-page-iterator .search-pages .page-links a.next, .taglib-page-iterator .search-pages .page-links span.next {
	background-image: url(/looking-glass-student-theme/images/arrows/paging_next.png);
	background-repeat: no-repeat;
}

.taglib-page-iterator .search-pages .page-links a.last, .taglib-page-iterator .search-pages .page-links span.last {
	background-image: url(/looking-glass-student-theme/images/arrows/paging_last.png);
	background-repeat: no-repeat;
}

.taglib-page-iterator .search-pages .page-links a.first, .taglib-page-iterator .search-pages .page-links span.first, .taglib-page-iterator .search-pages .page-links a.previous, .taglib-page-iterator .search-pages .page-links span.previous {
	padding-right: 5px;
}

.taglib-page-iterator .search-pages .page-links a.next, .taglib-page-iterator .search-pages .page-links span.next, .taglib-page-iterator .search-pages .page-links a.last, .taglib-page-iterator .search-pages .page-links span.last {
	background-position: 100% 0;
	padding-left: 5px;
}

.taglib-page-iterator .search-pages .page-links span.first, .taglib-page-iterator .search-pages .page-links span.previous {
	background-position: 0 100%;
}

.taglib-page-iterator .search-pages .page-links span.next, .taglib-page-iterator .search-pages .page-links span.last {
	background-position: 100% 100%;
}

.taglib-page-iterator .search-pages .delta-selector, .taglib-page-iterator .search-pages .page-selector, .taglib-page-iterator .search-pages .page-links {
	float: left;
}

.taglib-page-iterator .search-pages .page-selector {
	margin-left: 10px;
	margin-right: 10px;
	padding-left: 10px;
	padding-right: 10px;
}

/* ---------- Taglib social activities ---------- */

.taglib-social-activities .activity-separator {
	padding-bottom: 10px;
}

.taglib-social-activities .day-separator {
	border-bottom: 1px dotted #CCC;
	margin-bottom: 0px;
	margin-top: 10px;
	padding-bottom: 2px;
}

.taglib-social-activities .first-day-separator {
	border-bottom: 1px dotted #CCC;
	margin-bottom: 0px;
	margin-top: 0px;
	padding-bottom: 2px;
}

/* ---------- Taglib social bookmark ---------- */

.js .taglib-social-bookmarks.visible {
	background: #F0F5F7;
}

.js .taglib-social-bookmarks .show-bookmarks {
	display: block;
}

.js .taglib-social-bookmarks.visible .show-bookmarks {
}

.js .taglib-social-bookmarks ul {
	border: 1px solid #828F95;
	border-left: none;
	border-right: none;
	display: none;
}

.js .taglib-social-bookmarks.visible ul {
	display: block;
}

.taglib-social-bookmarks li {
	float: left;
	margin-right: 1em;
}

.taglib-social-bookmarks ul:after {
	clear: both;
	content: ".";
	display: block;
	height: 0;
	visibility: hidden;
}

.ie .taglib-social-bookmarks ul {
	height: 1%;
}

.taglib-social-bookmarks li a {
	background: url() no-repeat 0 50%;
	padding: 3px 2px 3px 20px;
}

.taglib-social-bookmarks a.taglib-social-bookmark-blinklist {
	background-image: url(/looking-glass-student-theme/images/social_bookmarks/blinklist.png);
}

.taglib-social-bookmarks a.taglib-social-bookmark-delicious {
	background-image: url(/looking-glass-student-theme/images/social_bookmarks/delicious.png);
}

.taglib-social-bookmarks a.taglib-social-bookmark-digg {
	background-image: url(/looking-glass-student-theme/images/social_bookmarks/digg.png);
}

.taglib-social-bookmarks a.taglib-social-bookmark-facebook {
	background-image: url(/looking-glass-student-theme/images/social_bookmarks/facebook.png);
}

.taglib-social-bookmarks a.taglib-social-bookmark-furl {
	background-image: url(/looking-glass-student-theme/images/social_bookmarks/furl.png);
}

.taglib-social-bookmarks a.taglib-social-bookmark-newsvine {
	background-image: url(/looking-glass-student-theme/images/social_bookmarks/newsvine.png);
}

.taglib-social-bookmarks a.taglib-social-bookmark-reddit {
	background-image: url(/looking-glass-student-theme/images/social_bookmarks/reddit.png);
}

.taglib-social-bookmarks a.taglib-social-bookmark-technorati {
	background-image: url(/looking-glass-student-theme/images/social_bookmarks/technorati.png);
}

/* ---------- Taglib tags summary ---------- */

.taglib-tags-summary .tag {
	background: url(/looking-glass-student-theme/images/common/tag.png) no-repeat 0 50%;
	margin-bottom: 3px;
	margin-right: 3px;
	padding: 2px 5px 2px 20px;
}

/* ---------- Taglib user display ---------- */

.taglib-user-display .user-details .user-name {
	clear: both;
	display: block;
}

.taglib-user-display .user-details.user-online .user-name {
}

.taglib-user-display .user-details .network-list {
	margin: 10px 0;
}

.taglib-user-display .user-details .network-list a {
	background: url() no-repeat 0 50%;
	display: block;
	padding-left: 20px;
}

.taglib-user-display .user-details .network-list .chat-user {
	background-image: url(/looking-glass-student-theme/images/common/conversation.png);
}

/* ---------- Taglib webdav ---------- */

.js .taglib-webdav.visible {
	background: #F0F5F7;
}

.js .taglib-webdav .show-webdav {
	display: block;
}

.js .taglib-webdav.visible .show-webdav {
}

.js .taglib-webdav table {
	border: 1px solid #828F95;
	border-left: none;
	border-right: none;
	display: none;
}

.js .taglib-webdav.visible table {
	display: block;
}

.taglib-webdav table:after {
	clear: both;
	content: ".";
	display: block;
	height: 0;
	visibility: hidden;
}

.ie .taglib-webdav table {
	height: 1%;
}

/* ---------- jQuery plugins ---------- */

/* ---------- Tabs ---------- */

.tabs-hide {
	display: none;
}

.ie6 .tabs-nav {
	display: inline-block;
}

/*.ie6 .tabs-nav .tabs-disabled a {
	filter: alpha(opacity=40);
}*/

/* ----------- OpenID ---------- */

input[type="text"].openid-login {
	background: url(/looking-glass-student-theme/images/common/openid.gif) no-repeat;
	background-color: #fff;
	background-position: 0 50%;
	color: #000;
	padding-left: 18px;
}

.ie6 input.text.openid-login {
	background: url(/looking-glass-student-theme/images/common/openid.gif) no-repeat;
	background-color: #fff;
	background-position: 0 50%;
	color: #000;
	padding-left: 18px;
}

/* ----------- Accessibility ---------- */

img.label-icon {
	border: 0px;
	float: left;
}

img.icon {
	border: 0px;
	/*float: absmiddle;*/
}

img.avatar {
	border: 0px;
}

td.stretch {
	width: 99%;
}

.nobr {
	white-space: nowrap;
}

/*------------Tableless Layouts-------------*/

.table {
	clear:both;
	display: table;
    border-collapse:collapse;
}
.tr {
	display: table-row;
}
.tr-col1{
display: block;}

.thead {
	display: table-header-group;
}
.tbody {
	display: table-row-group;
}
.tfoot {
	display: table-footer-group;
}
.col {
	display: table-column;
}
.colgroup {
	display: table-column-group;
}
.td, .th {
	display: table-cell;
	vertical-align:top;
}
.td-col1{
display:block;}
.caption {
	display: table-caption;
}

.position {
	position: absolute;
	top:-999em;
	width:10px;
	height:10px;
}
.border_none {
	border:none !important;
	padding:0px;
	padding:0px; margin:0px;
}
table.taglib-search-iterator tr:hover td {
	background-color:#f8f8f8;
}











/*============TableLess Layout=============*/
.container{
  width:100%;
  margin-bottom:10px;
  height:auto;
  overflow:hidden;
}
.position {
	display: block;
	height: 20px;
	/*left: -999em;*/
	position: absolute;
	width: 100px;
}
.row{
  width:100%;
  float:left;
  clear:both;
  margin-bottom:10px;
}

.content{
  width:98%;
  margin:auto;
  margin-bottom:10px;
  height:auto;
  overflow:hidden;
}


.column-1,
.column-2,
.column-3,
.column-4,
.column-5,
.column-6,
.column-7,
.column-8,
.column-9,
.column-10,
.column-11,
.column-12,
.column-13,
.column-14,
.column-15,
.column-16{
	float:left;
	margin-left:1%;
	min-height:30px;
}

.dragging .column-1,
.dragging .column-2,
.dragging .column-3,
.dragging .column-4,
.dragging .column-5,
.dragging .column-6,
.dragging .column-7,
.dragging .column-8,
.dragging .column-9,
.dragging .column-10,
.dragging .column-11,
.dragging .column-12,
.dragging .column-13,
.dragging .column-14,
.dragging .column-15,
.dragging .column-16{
	margin-left:0;
    background:#f2f2f2;
}

.column-1:first-child ,
.column-2:first-child ,
.column-3:first-child ,
.column-4:first-child ,
.column-5:first-child ,
.column-6:first-child ,
.column-7:first-child ,
.column-8:first-child ,
.column-9:first-child ,
.column-10:first-child ,
.column-11:first-child ,
.column-12:first-child,
.column-13:first-child,
.column-14:first-child,
.column-15:first-child,
.column-16:first-child {
	float:left;
	margin-left:0;	
}


.column-1{
	width:5.3125%;
	}
.column-2{
	width:11.625%;
	}
.column-3{
	width:17.9375%;
	}
.column-4{
	width:24.25%;
	}
.column-5{
	width:30.5625%;
	}
.column-6{
	width:36.875%;
	}
.column-7{
	width:43.1875%;
	}
.column-8{
	width:49.5%;
	}
.column-9{
	width:55.8125%;
	}
.column-10{
	width:62.125%;
	}
.column-11{
	width:68.4375%;
	}
.column-12{
	width:74.75%;
	}
.column-13{
	width:81.0625%;
	}
.column-14{
	width:87.375%;
	}
.column-15{
	width:93.6875%;
	}
.column-16{
	width:100%;
	}

.lfr-grid .lfr-column {
    padding:0px;
}





.float-right {
    float: right;
}
.float-left {
    float: left;
}
.text-right{
  text-align:right !important;
}

.text-left{
  text-align:left !important;
}

.text-middle{
  text-align:center;
}
.text-justify{
  text-align:justify;
}

.margin-t-6{
  margin-top:6px !important;
}

.margin-l-5{
  margin-left:5px !important;
}

.margin-l-10{
  margin-left:10px !important;
}

.margin-b-5{
  margin-bottom:5px !important;
}

.margin-b-50{
  margin-bottom:50px !important;
}

.margin-t-10{
  margin-top:10px !important;
}

.margin-l-0{
  margin-left:0px !important;
}

.margin-b-0{
  margin-bottom:0px !important;
}

.margin-r-10{
  margin-right:10px !important;
}

.margin-5{
  margin:5px !important;
}

.padding-10{
  padding:10px !important;
}

.padding-15{
  padding:15px !important;
}

.padding-t-10{
  padding-top:10px !important;
}

.padding-t-13{
  padding-top:13px !important;
}

.padding-t-15{
  padding-top:15px !important;
}

.padding-l-15{
  padding-left:15px !important;
}

.padding-b-10{ 
  padding-bottom:10px;
}

.padding-r-15{
  padding-right:15px !important;
}

.padding-r-10{
  padding-right:10px !important;
}

.width-100{
  width:100%;
}

.width-98{
  width:98% !important;
}

.width-90{
  width:90% !important;
}
.width-95 {
  width:95% !important;
}
.width-85{
  width:85% !important;
}

.width-25{
  width:25% !important;
}
.width-50{
  width:50% !important;
}

.font-11{
  font-size:11px !important;
}

.font-12{
  font-size:12px !important;
}

.font-13{
  font-size:13px !important;
}

.font-16{
  font-size:16px !important;
}

.line-height-40{
  line-height:50px;
}

.line-height-20{
  line-height:20px;
}

.line-height-30{
  line-height:30px;
}

.message-contentbox{border:solid 1px #e5e5e5; padding-bottom:5px;}
.deleteMsg, .ExportMsg{display:none;}
                
.white{
  color:#fff !important;
}

.icon-close{
	font-size:20px !important;
	font-weight:normal !important;
}

.border{
  border-right:solid 2px #fff;
  border-bottom:solid 2px #fff;
}

.pagination-border{
  border-top:solid 1px #e5e5e5;
  border-bottom:solid 1px #e5e5e5;
  padding:5px;
}

.help-block{
  font-size:11px;
  color:#808080;
  float:left;
  width:100%;
  line-height:25px;
}
.nospace{
  margin:0px !important;
  padding:0px !important;
}
.msg-center{
	font-family:Segoe UI, Arial, Helvetica, sans-serif;
  color:#707171;
  }

.accordion.default, .show-hide.default{
  border:0px;
  border-radius:0px;
}

.accordion.default .accordion-header, .show-hide.default .show-hide-header{
  background:#f8f8f8;
  padding:8px 4px 8px 10px;
  border-radius:4px 4px 0px 0px;
  margin:2px 0px 0px 0px;
}
 
.accordion.default .accordion-content, .show-hide.default .show-hide-content{
  border:0px;
  border-top:none;
  border-radius:0px 0px 4px 4px;
  margin:0px 0px 2px 0px;
  padding:10px;
}

.accordion-header a {font-size:16px; color:#333; text-transform: capitalize;}



.allcheck {
  display: inline-block;
  padding: 8px 7px 6px;
  margin-bottom: 0;
  font-size: 14px;
  line-height: 20px;
  color: #333333;
  text-align: center;
  text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
  vertical-align: middle;
  cursor: pointer;
  background-color: #f8f8f8;
  border: 1px solid #e0e0e0;
}



#page-cover{
	position:fixed;
	left:0px;
	right:0px;
	width:100%;
	height:100%;
	bottom:0px;
	background:#fff;
	opacity:.5;
	z-index:33;
	display:none;
}
	
.popup-heading{
	font-weight:normal !important;
	font-size:17px !important;
	border-bottom:solid 1px #e5e5e5;
	padding:0px 1% 0 1% !important;
	width:98% !important;
	line-height:35px;
  	background-color:#267bbd;
	color:#fff !important;
	margin-top:0px !important;
}

.popup-content{
	float:left;
	width:100%;
	max-height:400px;
	height:auto;
	overflow:auto;
}
.popup {
	position: absolute;
	min-width: 200px;
	min-height: 200px;
	height: auto;
	width: auto;
	top: -999em;
	left: 40%;
	right: 40%;
	border: 1px solid #000;
	opacity: 0;
	background-color: #fff;
	border: 1px solid #999;
	border: 1px solid rgba(0,0,0,.2);
	border-radius: 6px;
	-webkit-box-shadow: 0 3px 9px rgba(0,0,0,.5);
	box-shadow: 0 3px 9px rgba(0,0,0,.5);
	background-clip: padding-box;
	outline: 0;
}
.overlay {
	width: 100%;
	height: 100%;
	left: 0px;
	right: 0px;
	top: 0px;
	bottom: 0px;
	position: fixed;
	z-index: 999;
	background: #000;
	opacity: .5;
}
.show-popup {
	height: 450px;
    left: 50%;
    margin-left: -325px;
    margin-top: -220px;
    position: fixed;
    top: 50%;
    width: 700px;
    z-index: 9999;
}
.close-popup {
	width: 17px;
	height: 22px;
	z-index: 999;
	margin-top:18px;
	position:relative;
}

.close-popup a{
	position:absolute;
	left:0px;
	right:0px;
	top:0px;
    width:15px;
    height:15px;
	bottom:0px;
	display:block;
	line-height:0px;
    }
    
.ui-multiselect { padding:2px 0 2px 4px; text-align:left; background:#fff; border:solid 1px #e5e5e5; font-size:12px; padding:5px 5px; color:#666; }
.ui-multiselect span.ui-icon { float:right }
.ui-multiselect-single .ui-multiselect-checkboxes input { position:absolute !important; top: auto !important; left:-9999px; }
.ui-multiselect-single .ui-multiselect-checkboxes label { padding:5px !important }
 
.ui-multiselect-header { margin-bottom:3px; padding:3px 0 3px 4px; height:auto; overflow:hidden; }
.ui-multiselect-header ul { font-size:0.7em; list-style:none; font-weight:bold; }
.ui-multiselect-header ul li { float:left; padding:0 20px 0 0; }
.ui-multiselect-header a { text-decoration:none }
.ui-multiselect-header a:hover { text-decoration:underline }
.ui-multiselect-header span.ui-icon { float:left }
.ui-multiselect-header li.ui-multiselect-close { float:right; text-align:right; padding-right:0 }
 
.ui-multiselect-menu { display:none; padding:2px; position:absolute; z-index:10000; text-align: left; background:#fff; border-left:solid 1px #e5e5e5; border-right:solid 1px #e5e5e5; border-bottom:solid 1px #e5e5e5;
-moz-box-shadow: 0 3px 5px #888;
-webkit-box-shadow: 0 3px 5px#888;
box-shadow: 0 3px 5px #888;}
.ui-multiselect-checkboxes { position:relative /* fixes bug in IE6/7 */; overflow-y:auto; }
.ui-multiselect-checkboxes label { cursor:default; display:block; border:1px solid transparent; padding:1px 5px; font-size:12px; }
.ui-multiselect-checkboxes label input { position:relative; top:-1px }
.ui-multiselect-checkboxes li { clear:both; font-size:0.9em; padding-right:3px }
.ui-multiselect-checkboxes li.ui-multiselect-optgroup-label { text-align:center; font-weight:bold; border-bottom:1px solid }
.ui-multiselect-checkboxes li.ui-multiselect-optgroup-label a { display:block; padding:3px; margin:1px 0; text-decoration:none }
.ui-multiselect-checkboxes label span{ padding-left:5px;}
.ui-multiselect-filter input[type="search"] { width:95% !important; margin-bottom:5px !important;}
* html .ui-multiselect-checkboxes label { border:none }
.ui-multiselect { position:relative;}
.ui-multiselect .ui-icon-triangle-2-n-s{border-left: 4px solid rgba(0, 0, 0, 0); border-right: 4px solid rgba(0, 0, 0, 0); border-top: 4px solid #000000; content: ""; display: block; position: absolute; right: 10px;top: 47%; height: 0;vertical-align: top; width: 0;}

.ui-multiselect-selectall{
	padding:0px;
	margin:0px;
	font-size:1em;}

.ui-multiselect-header ul.ui-multiselect-selectall{
	font-size:1.1em;
	}

.ui-multiselect-selectall li#selectAllMultiSel{
	padding:4px 0px 4px 21px;
	margin:0px;
	list-style-type:none;
	list-style:none;
	}

.ui-multiselect-selectall li#selectAllMultiSel label{
	padding:0px 0px 0px 10px;}

.ui-multiselect-selectall li {
    list-style-type: none;
}

.msg-center h1,
.msg-center h2,
.msg-center h3,
.msg-center h4,
.msg-center h5,
.msg-center h6 {
  margin: 10px 0;
  font-family: inherit;
  font-weight: normal;
  line-height: 40px;
  color: inherit;
}

.msg-center h1 small,
.msg-center h2 small,
.msg-center h3 small,
.msg-center h4 small,
.msg-center h5 small,
.msg-center h6 small {
  font-weight: normal;
  line-height: 1;
  color: #999999;
}

.msg-center h4{
  font-size:15px !important;
  margin:0px !important;
  line-height:23px !important;
  color:#494949 !important;
}

.hide-elements .allcheck, .hide-elements .pagination-border{display:none;}

.msg-center .inboxmsg a, .msg-center .sentmsg a, .msg-center .pref a {
    color: #494949 !important;
    font: 14px Segoe UI,Arial,Helvetica,sans-serif;
    text-decoration: none;
}
.msg-center .inboxmsg a:hover, .msg-center .sentmsg a:hover, .msg-center .pref a:hover {
    text-decoration: underline;
}




/* ---------- Global Search ---------- */

#selectOption button.ui-multiselect{width:215px !important;}

#search-options {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #CCCCCC;
    border-radius: 5px;
    box-shadow: 1px 1px 5px rgba(50, 50, 50, 0.75);
    display: none;
    height: auto;
    margin-top:4px;
    position: absolute;
    width: 342px;
    z-index: 999;
}

#search-options-heading {
    background:#F1F1F1;
    font-weight: bold;
    height: 15px;
 	width: 98%;
    margin: auto;
    padding: 6px 1%;
}
#search-options-choose {
    background:#e3e3e3;
    font-weight:bold;
 	width: 326px;
    margin: auto;
    padding: 8px;
}

#checkall {
    height: 15px;
    font-weight:bold;
    font-size:12px;
 	width: 98%;
    margin: auto;
    padding: 6px 1%;
}


#search-options ul {
    margin: 0;
    padding: 0;
}

#search-options ul li {
    list-style-type: none;
    margin: 0;
    padding:8px 30px 8px 5px;
    font-size:12px;
}

#search-options-footer{
	background:#F1F1F1;
    font-weight: bold;
    margin: auto;
    padding: 6px 28px 6px 0;
	float:right;
    text-align:right;
    width:314px;
}

.search-options-btn{
	padding:3px 12px;
	margin-top:-1px ;
}

#make-me-primary,#uncheck-all{
	float:right;
}

.rad-label {
    visibility: hidden;
}
.search-radgroup{
	float:right;
}

/* ---------- End Global Search ---------- */

.get-count{ background: none repeat scroll 0 0 #FF0000;
    border-radius: 25px;
    font-size: 10px;
    line-height: 10px;
    margin: -6px 0 0 -11px !important;
    padding: 2px 5px !important;
    position: absolute;}
    




.portlet-tab-menu{
	display:none;
}


.last-menu span.line {
    background: none repeat scroll 0 0 #CCCCCC;
    display: block;
    font-size: 0;
    height: 2px;
    margin: 4px auto;
    text-indent: 0;
    width: 100%;
}

.last-menu:hover span.line {
    background: none repeat scroll 0 0 #000;
}


.lfr-install-more{ display:none;}
#portal_add_content .portlet-msg-info{ border-radius:0px; padding:5px 5px 5px 35px;}




@media screen and (max-width: 768px) {

#wrapper{ padding:0px 10px;}

.column-1,
.column-2,
.column-3,
.column-4,
.column-5,
.column-6,
.column-7,
.column-8,
.column-9,
.column-10,
.column-11,
.column-12,
.column-13,
.column-14,
.column-15,
.column-16{
	float:left;
	min-height:30px;
	width:100%;
	margin-left:0;
}


}


.cf {
	clear: both;
	font-size: 0px;
	height: 0px;
	padding: 0px;
	margin: 0px;
}

.clear-float{ clear:both;}







.active-area{ background:#dfdfdf !important;}

.dragging .column-container .portlet-sort-helper{ max-width:100% !important;}

.dragging{
	display: table !important;
}

.dragging .column-container{
	display: table-row !important;
}

.lfr-grid.dragging .lfr-column {
		display: table-cell !important;
		vertical-align:top;
        float:none !important;
}



.imgSearchBtn, .docSearchBtn {
   	line-height:1px !important;
	padding:0 0 0 2px;
}

img.avatar {
    max-height: 110px;
    max-width: 110px;
}

#p_p_id_11_ .details{
overflow:visible !important;
}

#p_p_id_11_ .property-list{
min-width:320px;
}

.border-none{
border:0px solid #fff;
}

.padding-none{
padding:0px;}

.sr-only {
position: absolute;
width: 1px;
height: 1px;
padding: 0;
margin: -1px;
overflow: hidden;
clip: rect(0,0,0,0);
border: 0;
}

.portlet-restricted {
display:none;
}
