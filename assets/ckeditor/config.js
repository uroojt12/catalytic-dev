/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'basicstyles', groups: [ 'styles','basicstyles', 'cleanup', 'blocks', 'align', 'indent','others', 'list', 'bidi', 'colors','find', 'selection', 'spellchecker', 'links','insert'] },
		// '/',
		{ name: 'tools', groups: ['tools','mode', 'document', 'doctools', 'undo']},
		// { name: 'about', groups: ['tools', 'mode', 'document', 'doctools', 'undo', 'about'] }
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	// config.removeButtons = 'Underline,Subscript,Superscript';
	config.removeButtons = 'Paste,PasteText,PasteFromWord,Anchor,Scayt';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;h4;h5;h6;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';

	// config.extraPlugins = 'uploadimage';
	config.uploadUrl = base_url+'/ajax/upload_editor_attach';
	config.filebrowserUploadUrl = base_url+'/ajax/upload_editor_attach';


	config.font_names = 'Arial;sans-serif;Helvetica;Times; serif;Times New Roman;Verdana;Trebuchet MS;lite';
	// config.font_names = 'Arial;sans-serif;Helvetica;Times; serif;Times New Roman;Verdana;Trebuchet MS;Apple Color Emoji;Segoe UI Emoji;Segoe UI Symbol;lite';

};
