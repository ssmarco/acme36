<?php

class Page_Controller extends ContentController
{
    /**
     * An array of actions that can be accessed via a request. Each array element should be an action name, and the
     * permissions or conditions required to allow the user to access it.
     *
     * <code>
     * array (
     *     'action', // anyone can access this action
     *     'action' => true, // same as above
     *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
     *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
     * );
     * </code>
     *
     * @var array
     */
    private static $allowed_actions = array(
        'marco',
        'Search',
        // 'SearchForm',
    );

    public function init()
    {
        parent::init();
        // You can include any CSS or JS required by your project here.
        // See: http://doc.silverstripe.org/framework/en/reference/requirements
    }

    // /**
    //  * Site search form MYSQL
    //  */
    // public function SearchForm()
    // {
    //     $searchText = $this->getRequest()->getVar('Search');

    //     $fields = new FieldList(
    //         TextField::create('Search', false, $searchText)
    //     );
    //     $actions = new FieldList(
    //         new FormAction('results', _t('SearchForm.GO', 'Go'))
    //     );

    //     $form = SearchForm::create($this, 'SearchForm', $fields, $actions);
    //     $form->setFormAction('home/SearchForm');

    //     return $form;
    // }

    /**
     * Solr
     * @param [type] $request [description]
     */
    public function Search($request)
    {
        $query = new SearchQuery();
        $query->search($request->getVar('Search'));
        $results = singleton('MyIndex')->search($query);
        $templates = array('Page_results', 'Page');
        $response = $this->customise(
            array('Results' => $results->Matches)
        );
        return $response->renderWith($templates);
    }
}
