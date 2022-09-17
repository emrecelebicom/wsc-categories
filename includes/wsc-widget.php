<?php

if(!class_exists("WSC_Widget"))
{
    class WSC_Widget extends WP_Widget
    {
        public function __construct()
        {
            parent::WP_Widget(false, "WSC Categories");
        }

        public function form($instance)
        {
            
            $wsc_title = !empty($instance) ? $instance['wsc_title'] : "";
            $wsc_query_content = !empty($instance) ? $instance['wsc_query_content'] : "";
            $wsc_query_orderby = !empty($instance) ? $instance['wsc_query_orderby'] : "";
            $wsc_query_order = !empty($instance) ? $instance['wsc_query_order'] : "";
            $wsc_query_list_option = !empty($instance) ? $instance['wsc_query_list_option'] : "";
            $wsc_exclude_categories = !empty($instance) ? $instance['wsc_exclude_categories'] : "";
            $wsc_class = !empty($instance) ? $instance['wsc_class'] : "";

            $content = "<div class=\"wsc_wrapper\">";

            /* Title */
            $content .= "<label for=\"".$this->get_field_id('wsc_title')."\" class=\"wsc-label\">Title</label>";
            $content .= "<input type=\"text\" id=\"".$this->get_field_id('wsc_title')."\" name=\"".$this->get_field_name('wsc_title')."\" value=\"".$wsc_title."\" class=\"wsc-input\" />";

            /* Query Content */
            $content .= "<label for=\"".$this->get_field_id('wsc_query_content')."\" class=\"wsc-label\">Query Content</label>";
            $content .= "<select id=\"".$this->get_field_id('wsc_query_content')."\" name=\"".$this->get_field_name('wsc_query_content')."\">";
            $content .= "<option>Choose</option>";
            $content .= "<option value=\"category\"".($wsc_query_content == "category" ? " selected" : "").">Post Category</option>";
            $content .= "<option value=\"product_cat\"".($wsc_query_content == "product_cat" ? " selected" : "").">Product Category</option>";
            $content .= "</select>";

            /* Query Orderby */
            $content .= "<label for=\"".$this->get_field_id('wsc_query_orderby')."\" class=\"wsc-label\">Query Order</label>";
            $content .= "<select id=\"".$this->get_field_id('wsc_query_orderby')."\" name=\"".$this->get_field_name('wsc_query_orderby')."\">";
            $content .= "<option>Choose</option>";
            $content .= "<option value=\"id\"".($wsc_query_orderby == "id" ? " selected" : "").">id</option>";
            $content .= "<option value=\"title\"".($wsc_query_orderby == "title" ? " selected" : "").">title</option>";
            $content .= "<option value=\"name\"".($wsc_query_orderby == "name" ? " selected" : "").">name</option>";
            $content .= "<option value=\"menu_order\"".($wsc_query_orderby == "menu_order" ? " selected" : "").">menu order</option>";
            $content .= "<option value=\"rand\"".($wsc_query_orderby == "rand" ? " selected" : "").">random</option>";
            $content .= "</select>";

            /* Query Order */
            $content .= "<label for=\"".$this->get_field_id('wsc_query_order')."\" class=\"wsc-label\">Query Orderby</label>";
            $content .= "<select id=\"".$this->get_field_id('wsc_query_order')."\" name=\"".$this->get_field_name('wsc_query_order')."\">";
            $content .= "<option>Choose</option>";
            $content .= "<option value=\"asc\"".($wsc_query_order == "asc" ? " selected" : "").">asc</option>";
            $content .= "<option value=\"desc\"".($wsc_query_order == "desc" ? " selected" : "").">desc</option>";
            $content .= "</select>";

            /* Query List Option */
            $content .= "<label for=\"".$this->get_field_id('wsc_query_list_option')."\" class=\"wsc-label\">Query List Option</label>";
            $content .= "<select id=\"".$this->get_field_id('wsc_query_list_option')."\" name=\"".$this->get_field_name('wsc_query_list_option')."\">";
            $content .= "<option>Choose</option>";
            $content .= "<option value=\"all\"".($wsc_query_list_option == "all" ? " selected" : "").">List all categories</option>";
            $content .= "<option value=\"main-categories\"".($wsc_query_list_option == "main-categories" ? " selected" : "").">List main categories</option>";
            $content .= "<option value=\"sub-categories\"".($wsc_query_list_option == "sub-categories" ? " selected" : "").">List sub categories</option>";
            $content .= "<option value=\"parent-categories\"".($wsc_query_list_option == "parent-categories" ? " selected" : "").">List parent categories</option>";
            $content .= "</select>";

            /* Exclude Categories */
            $content .= "<label for=\"".$this->get_field_id('wsc_exclude_categories')."\" class=\"wsc-label\">Exclude Categories</label>";
            $content .= "<input type=\"text\" id=\"".$this->get_field_id('wsc_exclude_categories')."\" name=\"".$this->get_field_name('wsc_exclude_categories')."\" value=\"".$wsc_exclude_categories."\" class=\"wsc-input\" />";

            /* Classname */
            $content .= "<label for=\"".$this->get_field_id('wsc_class')."\" class=\"wsc-label\">Classnames</label>";
            $content .= "<input type=\"text\" id=\"".$this->get_field_id('wsc_class')."\" name=\"".$this->get_field_name('wsc_class')."\" value=\"".$wsc_class."\" class=\"wsc-input\" />";

            $content .= "</div>";

            echo $content;
        }

        public function update($new_instance, $old_instance)
        {
            $instance = $old_instance;
            $instance['wsc_title'] = $new_instance['wsc_title'];
            $instance['wsc_query_content'] = $new_instance['wsc_query_content'];
            $instance['wsc_query_orderby'] = $new_instance['wsc_query_orderby'];
            $instance['wsc_query_order'] = $new_instance['wsc_query_order'];
            $instance['wsc_query_list_option'] = $new_instance['wsc_query_list_option'];
            $instance['wsc_exclude_categories'] = $new_instance['wsc_exclude_categories'];
            $instance['wsc_class'] = $new_instance['wsc_class'];
            return $instance;
        }

        public function widget($args, $instance)
        {
            extract($args);

            if($instance['wsc_query_list_option'] == "main-categories"){
                $parent_cat = 0;
            }elseif($instance['wsc_query_list_option'] == "sub-categories"){
                $parent_cat = get_term_by('slug', get_queried_object()->slug, $instance['wsc_query_content'])->term_id;
            }elseif($instance['wsc_query_list_option'] == "parent-categories"){
                $parent_cat = get_term_by('slug', get_queried_object()->slug, $instance['wsc_query_content'])->parent;
            }else{
                $parent_cat = null;
            }

            echo "<div class=\"".$instance['wsc_class']."\">"; //TODO: before_widget'e eklenecek.
            echo $before_widget;
            //echo "<h3>".$instance['wsc_title']."</h3>";
            echo $before_title;
            echo $instance['wsc_title'];
            echo $after_title;
            //var_dump($this->WSC_Query($instance['wsc_query_content'], $instance['wsc_query_orderby'], $instance['wsc_query_order'], $parent_cat));
            echo "<ul>";
            foreach($this->WSC_Query($instance['wsc_query_content'], $instance['wsc_query_orderby'], $instance['wsc_query_order'], $parent_cat, $instance['wsc_exclude_categories']) as $item)
            {
                echo "<li><a href=\"".$item->permalink."\">".$item->name."</a></li>";
            }
            echo "</ul>";
            echo $after_widget;
            echo "</div>";
        }

        public function WSC_Query($query_content = "category", $query_orderby = "id", $query_order = "desc", $query_parent = null, $exclude = null)
        {
            $items = [];

            $args = array(
                'taxonomy' => $query_content,
                'orderby'   => $query_orderby,
                'order' => $query_order
            );

            if($query_parent !== null) $args['parent'] = $query_parent;

            if($exclude !== null){
                $args['exclude'] = explode(",", $exclude);
            }

            $query = get_categories( $args );

            return $query;
        }
    }
}