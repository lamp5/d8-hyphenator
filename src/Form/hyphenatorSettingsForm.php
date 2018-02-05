<?php

namespace Drupal\hyphenator\Form;



use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


class hyphenatorSettingsForm extends ConfigFormBase{

  public function getFormId()
  {
    return 'hyphenator_admin_settings';
  }

  protected function getEditableConfigNames(){
    return [
      'hyphenator.settings',
    ];
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $config = $this->config('hyphenator.settings');

    $lang = [];

    $lang['auto'] = 'Auto';
    foreach(\Drupal::languageManager()->getLanguages() as $key => $value){
      $lang[$key] = $value->getName();
    }

    $form['classname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Class name'),
      '#description' => $this->t('Add class for example .hyphenate. All divs with this class will be hyphenate'),
      '#default_value' => $config->get('classname'),
    ];

    $form['donthyphenateclassname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Dont hyphenate class name'),
      '#description' => $this->t('You can redefine the classname that marks elements that should not be hyphenated'),
      '#default_value' => $config->get('donthyphenateclassname'),
    ];

    $form['urlclassname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Url class name'),
      '#default_value' => $config->get('urlclassname'),
    ];

    $form['minwordlength'] = [
      '#type' => 'number',
      '#min' => 1,
      '#title' => $this->t('Min word length'),
      '#description' => $this->t('By default Hyphenator.js only hyphenates words with a minimum of 6 letters. You can change this values. The higher the value, the faster the script; the lower the value, the better the result.'),
      '#default_value' => $config->get('minwordlength'),
    ];

    $form['hyphenchar'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Hyphenchar'),
      '#description' => $this->t('By default Hyphenator.js puts the soft hyphen in each possible hyphenation point. Soft hyphens are invisible unless the line is breaked.'),
      '#default_value' => $config->get('hyphenchar'),
    ];

    $form['urlhyphenchar'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Url Hyphenchar'),
      '#description' => $this->t('When processing URLs and email-adresses a hyphen would invalidate the text. Thus, by default, a zero width space is used instead.'),
      '#default_value' => $config->get('urlhyphenchar'),
    ];

    $form['remoteloading'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Remote loading'),
      '#description' => $this->t('Hyphenator.js automatically loads the pattern files for each language, if they are available. Alternatively you can load the pattern files manually and disable the remote loading mechanism.'),
      '#default_value' => $config->get('remoteloading'),
    ];

    $form['enablecache'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable cache'),
      '#description' => $this->t('Hyphenator caches words that have been hyphenated to fasten execution. If for some reason (memory?) you want to disable caching, you can do it.'),
      '#default_value' => $config->get('enablecache'),
    ];

    $form['enablereducedpatternset'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable reduced pattern set'),
      '#description' => $this->t('This property is used by the reducePatternSet-tool. It stores all patterns used in a run in the language-object. They can be retrieved with the Hyphenator.getRedPatternSet(lang)-method.'),
      '#default_value' => $config->get('enablereducedpatternset'),
    ];

    $form['intermediatestate'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Intermediate state'),
      '#description' => $this->t('When a paragraph is hyphenated, the browser does a reflow of the layout, which you might like or not.'),
      '#default_value' => $config->get('intermediatestate'),
    ];

    $form['safecopy'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Safe copy'),
      '#description' => $this->t('This property this property tells Hyphenator.js if it should remove hyphenation from copied text.'),
      '#default_value' => $config->get('safecopy'),
    ];

    $form['doframes'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Do frames'),
      '#description' => $this->t('Hyphenator does not automatically hyphenate text in frames nor iframes. But you can turn this feature on. Remember: due to the Same Origin Policy scripts can only access frames with the same origin.'),
      '#default_value' => $config->get('doframes'),
    ];

    $form['storagetype'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Storage type'),
      '#description' => $this->t('By default the storage method is localStorage but you can change this to sessionStorage (option \'session\')or turn this feature off (by setting storagetype to \'none\'.'),
      '#default_value' => $config->get('storagetype'),
    ];

    $form['orphancontrol'] = [
      '#type' => 'number',
      '#min' => 1,
      '#title' => $this->t('Orphan control'),
      '#description' => $this->t('In some cases it may happen that one single syllable comes to the last line. To prevent this you may set the orphancontrol-level to one of the following values: 1 (default): last word is hyphenated, 2: last word is not hyphenated, 3: last word is not hyphenated and last space is non breaking'),
      '#default_value' => $config->get('orphancontrol'),
    ];

    $form['dohyphenation'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Do hyphenation'),
      '#description' => $this->t('Sometimes you like to run the script, prepare everything, but not to hyphenate yet. In this case you can set the option dohyphenation to false. Hyphenation can later be executed by calling Hyphenator.toggleHyphenation();'),
      '#default_value' => $config->get('dohyphenation'),
    ];

    $form['persistentconfig'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Persistent config'),
      '#description' => $this->t('With the option persistentconfig set to true (default is false), all configuration options are stored in a object called Hyphenator_config in the storage type defined by the property storagetype (if storagetype is none or storage isn\'t supported, nothing is stored). By reloading or going to an other page, those settings remain set. This is very and specially usefull for the toggle-button. Be carefull with this option!'),
      '#default_value' => $config->get('persistentconfig'),
    ];

    $form['defaultlanguage'] = [
      '#type' => 'select',
      '#title' => $this->t('Default language'),
      '#description' => $this->t('If you can\'t set a lang-attribute to the appropriate html-tag it may be interesting to set the default language.'),
      '#default_value' => $config->get('defaultlanguage'),
      '#options' => $lang,
    ];

    $form['useCSS3hyphenation'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Use CSS3 hyphenation'),
      '#description' => $this->t('Modern browsers are implementing CSS3-Hyphenation. In cases where CSS3-Hyphenation is supported by the browser, Hyphenator.js can activate it for the supported languages instead of computing the hyphenation points by itself. This is fast and don\'t require to download the patterns which is nice for mobile browsers (e.g. iPad/iPhone).'),
      '#default_value' => $config->get('useCSS3hyphenation'),
    ];

    $form['unhide'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Unhide'),
      '#description' => $this->t('By default – if intermediatestateis set to the default hidden (see above) – Hyphenator.js waits until all elements are processed (hyphenated) and finally unhides them. In some cases (e.g. in multilanguage documents, where multiple patterns have to be loaded) a progressive unhiding (i.e. not waiting for all elements but unhiding as soon as the respective patterns are loaded) is more usefull. Default: unhide = \'wait\''),
      '#default_value' => $config->get('unhide'),
    ];

    $form['leftmin'] = [
      '#type' => 'number',
      '#min' => 1,
      '#title' => $this->t('Left min'),
      '#description' => $this->t('Each language pattern file defines its own values for leftmin (the minimum of chars to remain on the old line) and rightmin (the minimum of chars to go on the new line). Sometimes it\'s usefull to overwrite them with larger values.'),
      '#default_value' => $config->get('leftmin'),
    ];

    $form['rightmin'] = [
      '#type' => 'number',
      '#min' => 1,
      '#title' => $this->t('Right min'),
      '#default_value' => $config->get('rightmin'),
    ];

    $form['compound'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Compound'),
      '#description' => $this->t('Hyphenation of compound words containing a \'-\' (e.g. factory-made) can be ugly:'),
      '#default_value' => $config->get('compound'),
    ];

    return parent::buildForm($form, $form_state); // TODO: Change the autogenerated stub
  }


  public function submitForm(array &$form, FormStateInterface $form_state)
  {

    $this->configFactory->getEditable('hyphenator.settings')
      ->set('classname', $form_state->getValue('classname'))
      ->set('donthyphenateclassname', $form_state->getValue('donthyphenateclassname'))
      ->set('urlclassname', $form_state->getValue('urlclassname'))
      ->set('minwordlength', $form_state->getValue('minwordlength'))
      ->set('hyphenchar', $form_state->getValue('hyphenchar'))
      ->set('urlhyphenchar', $form_state->getValue('urlhyphenchar'))
      ->set('remoteloading', $form_state->getValue('remoteloading'))
      ->set('enablecache', $form_state->getValue('enablecache'))
      ->set('enablereducedpatternset', $form_state->getValue('enablereducedpatternset'))
      ->set('intermediatestate', $form_state->getValue('intermediatestate'))
      ->set('safecopy', $form_state->getValue('safecopy'))
      ->set('doframes', $form_state->getValue('doframes'))
      ->set('storagetype', $form_state->getValue('storagetype'))
      ->set('orphancontrol', $form_state->getValue('orphancontrol'))
      ->set('dohyphenation', $form_state->getValue('dohyphenation'))
      ->set('persistentconfig', $form_state->getValue('persistentconfig'))
      ->set('defaultlanguage', $form_state->getValue('defaultlanguage'))
      ->set('useCSS3hyphenation', $form_state->getValue('useCSS3hyphenation'))
      ->set('unhide', $form_state->getValue('unhide'))
      ->set('leftmin', $form_state->getValue('leftmin'))
      ->set('rightmin', $form_state->getValue('rightmin'))
      ->set('compound', $form_state->getValue('compound'))
      ->save();

    parent::submitForm($form, $form_state); // TODO: Change the autogenerated stub
  }
}
