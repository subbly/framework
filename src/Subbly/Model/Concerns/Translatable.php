<?php

namespace Subbly\Model\Concerns;

use App;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\Eloquent\Model;

trait Translatable
{
    /** @var string  entry locale */
    protected $frontendLocale = null;

    /*
     * Define current locale
     */
    public function setFrontLocale($key = null)
    {
        if ($this->isKeyALocale($key)) {
            $this->frontendLocale = $key;
        }
    }

    /*
     * Get current locale
     */
    public function getFrontLocale()
    {
        if (is_null($this->frontendLocale)) {
            return App::make('config')->get('subbly.frontendFallbackLocale');
        }

        return $this->frontendLocale;
    }

    /*
     * Alias for getTranslation()
     */
    public function translate($locale = null, $fallback = false)
    {
        return $this->getTranslation($locale, $fallback);
    }

    /*
     * Alias for getTranslation()
     */
    public function translateOrDefault($locale)
    {
        return $this->getTranslation($locale, true);
    }

    public function getTranslation($locale = null, $fallback = false)
    {
        $locale = (!is_null($locale)) ? $locale : $this->getFrontLocale();
        $fallback = isset($this->useTranslationFallback) ? $this->useTranslationFallback : $fallback;

        if ($this->getTranslationByLocaleKey($locale)) {
            $translation = $this->getTranslationByLocaleKey($locale);
        } elseif ($fallback
            && App::make('config')->has('subbly.frontendLocales')
            && $this->getTranslationByLocaleKey(App::make('config')->get('subbly.frontendLocales'))
        ) {
            $translation = $this->getTranslationByLocaleKey(App::make('config')->get('subbly.frontendLocales'));
        } else {
            $translation = $this->getNewTranslationInstance($locale);
            $this->translations->add($translation);
        }

        return $translation;
    }

    public function hasTranslation($locale = null)
    {
        $locale = $locale ?: App::getLocale();

        foreach ($this->translations as $translation) {
            if ($translation->getAttribute($this->getLocaleKey()) == $locale) {
                return true;
            }
        }

        return false;
    }

    public function getTranslationModelName()
    {
        return $this->translationModel ?: $this->getTranslationModelNameDefault();
    }

    public function getTranslationModelNameDefault()
    {
        $config = App::make('config');

        return get_class($this).$config->get('app.translatable_suffix', 'Translation');
    }

    public function getRelationKey()
    {
        return $this->translationForeignKey ?: $this->getForeignKey();
    }

    public function getLocaleKey()
    {
        return $this->localeKey ?: 'locale';
    }

    public function translations()
    {
        return $this->hasMany($this->getTranslationModelName(), $this->getRelationKey());
    }

    public function getAttribute($key)
    {
        if ($this->isKeyReturningTranslationText($key)) {
            return $this->getTranslation()->$key;
        }

        return parent::getAttribute($key);
    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->translatedAttributes)) {
            $this->getTranslation()->$key = $value;
        } else {
            parent::setAttribute($key, $value);
        }
    }

    public function saveWithTranslation(array $options = array())
    {
        if ($this->exists) {
            if (count($this->getDirty()) > 0) {
                // If $this->exists and dirty, parent::save() has to return true. If not,
                // an error has occurred. Therefore we shouldn't save the translations.
                if (parent::save($options)) {
                    return $this->saveTranslations();
                }

                return false;
            } else {
                // If $this->exists and not dirty, parent::save() skips saving and returns
                // false. So we have to save the translations
                return $this->saveTranslations();
            }
        } elseif (parent::save($options)) {
            // We save the translations only if the instance is saved in the database.
            return $this->saveTranslations();
        }

        return false;
    }

    public function fill(array $attributes)
    {
        $totallyGuarded = $this->totallyGuarded();

        foreach ($attributes as $key => $values) {
            if ($this->isKeyALocale($key)) {
                $translation = $this->getTranslation($key);

                foreach ($values as $translationAttribute => $translationValue) {
                    if ($this->isFillable($translationAttribute)) {
                        $translation->$translationAttribute = $translationValue;
                    } elseif ($totallyGuarded) {
                        throw new MassAssignmentException($key);
                    }
                }
                unset($attributes[$key]);
            }
        }

        return parent::fill($attributes);
    }

    private function getTranslationByLocaleKey($key)
    {
        foreach ($this->translations as $translation) {
            if ($translation->getAttribute($this->getLocaleKey()) == $key) {
                return $translation;
            }
        }

        return;
    }

    protected function isKeyReturningTranslationText($key)
    {
        return in_array($key, $this->translatedAttributes);
    }

    protected function isKeyALocale($key)
    {
        $locales = $this->getLocales();

        return in_array($key, $locales);
    }

    protected function getLocales()
    {
        $config = App::make('config');

        return $config->get('subbly.frontendLocales', array());
    }

    protected function saveTranslations()
    {
        $saved = true;
        foreach ($this->translations as $translation) {
            if ($saved && $this->isTranslationDirty($translation)) {
                $translation->setAttribute($this->getRelationKey(), $this->getKey());
                $saved = $translation->save();
            }
        }

        return $saved;
    }

    protected function isTranslationDirty(Model $translation)
    {
        $dirtyAttributes = $translation->getDirty();
        unset($dirtyAttributes[$this->getLocaleKey()]);

        return count($dirtyAttributes) > 0;
    }

    protected function getNewTranslationInstance($locale)
    {
        $modelName = $this->getTranslationModelName();
        $translation = new $modelName();
        $translation->setAttribute($this->getLocaleKey(), $locale);

        return $translation;
    }

    public function __isset($key)
    {
        return (in_array($key, $this->translatedAttributes) || parent::__isset($key));
    }

    public function toArray()
    {
        $attributes = parent::toArray();
        foreach ($this->translatedAttributes as $field) {
            if ($translations = $this->getTranslation()) {
                $attributes[$field] = $translations->$field;
            }
        }

        return $attributes;
    }
}
