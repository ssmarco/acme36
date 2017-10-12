<?php

use Acme\Search\ClientFactory as SearchFactory;
use Acme\Search\Config as SearchConfig;

/**
 * Class SearchResultsPage
 *
 */
class SearchResultsPage extends Page
{
    protected $isAutoCreatedPage = true;
    protected $defaultUrlSegment = 'search';
    protected $defaultTitle = 'Search Results';
    public function canDeleteFromLive($member = null)
    {
        return false;
    }

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        // Remove fields
        $fields->removeByName('URLSegment');

        return $fields;
    }
}


/**
 * Class SearchResultsPage_Controller
 *
 * @property SearchResultsPage dataRecord
 * @method SearchResultsPage data()
 * @mixin SearchResultsPage dataRecord
 */
class SearchResultsPage_Controller extends Page_Controller
{
    private static $allowed_actions = array(
        'SearchForm',
    );
    /**
     * @return string
     */
    public function Form()
    {
        $searchText = Convert::raw2att($this->getRequest()->getVar('Search'));
        $searchText = $searchText ?: _t('SearchForm.SEARCH', 'Search');

        $fields = new FieldList(
            new TextField('Search', false, $searchText)
        );

        $actions = new FieldList(
            new FormAction('results', _t('SearchForm.GO', 'Go'))
        );

        $required = new RequiredFields(array(
            'Search'
        ));

        $form = SearchForm::create($this, 'SearchForm', $fields, $actions, $required);

        return $form;
    }

    /**
     * Process and render search results.
     *
     * @param array $data The raw request data submitted by user
     * @param SearchForm $form The form instance that was submitted
     * @param SS_HTTPRequest $request Request generated for this action
     * @return ViewableData_Customised
     */
    public function results($data, $form, $request)
    {
        $data['Results'] = [];
        $data['Query'] = DBField::create_field('Text', $form->getSearchQuery());
        $data['Title'] = _t('SearchForm.SearchResults', 'Search Results');
        $data['Warning'] = "An error occured.";

        $client = SearchFactory::create(
            SearchConfig::create(),
            $this
        );

        try {
            $data['Results'] = $client->query($request->getVar('Search'));
            $data['Warning'] = '';
        } catch (\Exception $exception) {
            $data['Warning'] .= ' ' . $exception->getMessage();
        }

        return $this->customise($data)
            ->renderWith(['Page_results', 'Page']);
    }
}
