<?php
/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Quick_Chat_Buttons
 * @subpackage Quick_Chat_Buttons/includes
 * @author     Klaxon.app <contact@klaxon.app>
 * @license    GPL2
 * @link       https://klaxon.app
 * @since      1.0.0
 */
class Quick_Chat_Buttons_Loader
{

    /**
     * The array of actions registered with WordPress.
     *
     * @var    array    $actions    The actions registered with WordPress to fire when the plugin loads.
     * @since  1.0.0
     * @access protected
     */
    protected $actions;

    /**
     * The array of filters registered with WordPress.
     *
     * @var    array    $filters    The filters registered with WordPress to fire when the plugin loads.
     * @since  1.0.0
     * @access protected
     */
    protected $filters;


    /**
     * Initialize the collections used to maintain the actions and filters.
     *
     * @since 1.0.0
     */
    public function __construct()
    {

        $this->actions = [];
        $this->filters = [];

    }//end __construct()


    /**
     * Add a new action to the collection to be registered with WordPress.
     *
     * @param string $hook         The name of the WordPress action that is being registered.
     * @param object $component    A reference to the instance of the object on which the action is defined.
     * @param string $callback     The name of the function definition on the $component.
     * @param int    $priority     Optional. The priority at which the function should be fired. Default is 10.
     * @param int    $acceptedArgs Optional. The number of arguments that should be passed to the $callback. Default is 1.
     */
    public function add_action($hook, $component, $callback, $priority=10, $acceptedArgs=1)
    {
        $this->actions = $this->add($this->actions, $hook, $component, $callback, $priority, $acceptedArgs);

    }//end add_action()


    /**
     * Add a new filter to the collection to be registered with WordPress.
     *
     * @param string $hook         The name of the WordPress filter that is being registered.
     * @param object $component    A reference to the instance of the object on which the filter is defined.
     * @param string $callback     The name of the function definition on the $component.
     * @param int    $priority     Optional. The priority at which the function should be fired. Default is 10.
     * @param int    $acceptedArgs Optional. The number of arguments that should be passed to the $callback. Default is 1
     */
    public function add_filter($hook, $component, $callback, $priority=10, $acceptedArgs=1)
    {
        $this->filters = $this->add($this->filters, $hook, $component, $callback, $priority, $acceptedArgs);

    }//end add_filter()


    /**
     * A utility function that is used to register the actions and hooks into a single
     * collection.
     *
     * @param  array  $hooks        The collection of hooks that is being registered (that is, actions or filters).
     * @param  string $hook         The name of the WordPress filter that is being registered.
     * @param  object $component    A reference to the instance of the object on which the filter is defined.
     * @param  string $callback     The name of the function definition on the $component.
     * @param  int    $priority     The priority at which the function should be fired.
     * @param  int    $acceptedArgs The number of arguments that should be passed to the $callback.
     * @return array                                  The collection of actions and filters registered with WordPress.
     */
    private function add($hooks, $hook, $component, $callback, $priority, $acceptedArgs)
    {

        $hooks[] = [
            'hook'          => $hook,
            'component'     => $component,
            'callback'      => $callback,
            'priority'      => $priority,
            'accepted_args' => $acceptedArgs,
        ];

        return $hooks;

    }//end add()


    /**
     * Register the filters and actions with WordPress.
     *
     * @since 1.0.0
     */
    public function run()
    {

        foreach ($this->filters as $hook) {
            add_filter($hook['hook'], [ $hook['component'], $hook['callback'] ], $hook['priority'], $hook['accepted_args']);
        }

        foreach ($this->actions as $hook) {
            add_action($hook['hook'], [ $hook['component'], $hook['callback'] ], $hook['priority'], $hook['accepted_args']);
        }

    }//end run()


}//end class
