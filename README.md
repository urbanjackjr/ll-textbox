# Learn Language Textbox
Tested up to: 5.9.3

Learn Language Textbox is a plugin that helps to learn languages through short text and stories. User can hover over a certain word and see its translation, as well as saving this word to go back to it later.

## Installation

1. Clone this repository
2. Upload cloned folder to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress

## Usage

<b>Firstly, you have to provide your Cloud Translate API key in plugin settings: `/wp-admin/options-general.php?page=ll-textbox-settings`</b>

Plugin provides two shortcodes: `textbox` and `saved_words`.
First one shows a textbox with a text provided by you. You can choose source and target languages to ensure correct translations.
Saved_words shows users' list of words, that he saved through textboxes.

### Example usage
`[textbox text="Człowiek niezmiernie lubi czuć się pokrzywdzony." source="PL" target="EN"]`
`[saved_words]`

## Screenshots

1. Textbox with PL source and EN.<br>![textbox](/assets/textbox.png)
2. Table of saved words<br>![saved words](/assets/saved_words.png)
