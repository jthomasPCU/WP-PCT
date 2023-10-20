<?php 
/**
* Template Name: FAQs Page
*/
get_header();

$faq = new WP_Query(array(
    'post_per_page' => -1,
    'post_type' => 'triptimefaq',
    'orderby' => 'date',
    'order' => 'ASC'
));

?>


<section id="content"> 
<div id="Content_C001_Col00" class="sf_colsIn container" data-sf-element="Container" data-placeholder-label="Container">
<div id="faq" class="faq-widget mt-5 mb-5">

    <h1 class="title">Frequently Asked Questions</h1>

    <input id="StartOnCategory" name="StartOnCategory" type="hidden" value="1f963312-2a9a-4545-be2a-9c0484eedcdf" />

        <div class="faq-search mt-5">
            <div class="row">
                <div class="col col-9">
                    <input type="text" v-model="searchText" placeholder="Search FAQs" />
                </div>
                <div class="col col-3">
                    <button v-on:click="clearSearch">Clear</button>
                </div>
            </div>
        </div>
        <div class="faq-categories-container mt-5">
            <ul class="faq-categories" v-if="categories.length > 0">
                <li v-for="category in categories" v-bind:key="category.id" v-if="categories.length > 0" v-bind:data-slug="category.slug">
                    <button v-on:click="selectCategory(category.id, $event)" v-bind:class="{ 'selected' : isSelectedCategoryOrParentOfSelectedCategory(category.id) }">{{ category.name }}</button>
                    <ul v-if="category.children.length && isSelectedCategoryOrParentOfSelectedCategory(category.id)">
                        <li v-for="child in category.children" v-bind:key="child.id" v-bind:data-slug="child.slug">
                            <button v-on:click="selectCategory(child.id, $event)" v-bind:class="{ 'selected' : (selectedCategory == child.id) }">{{ child.name }}</button>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    <div class="faq-list-container mt-5">
        <ul class="faq-list row row-eq-height" v-if="entries.length > 0" v-bind:class="{ 'singular-category' : (0 == categories.length) }">
            <?php 
                while($faq->have_posts()) {
                    $faq->the_post(); 
            ?>
            <li v-for="(entry, index) in entries" v-bind:key="entry.id"
                v-if="matchesSearch(entry.question) && matchesCategory(entry.categories)"
                v-on:click="selectEntry(entry, $event)"
                class="entry" v-bind:class="{ 'selected' : (selectedEntry == entry.id) }">
                <div class="row row-eq-height no-gutters">
                    <div class="col col-1 control"><span>+</span></div>
                    <div class="col col-11">
                        <div class="question">
                            <?php 
                                the_title(); 
                            ?>
                            <div class="answer">
                                    <?php 
                                the_content();
                                    ?>
                            </div>

                            <!-- {{ entry.question }} -->
                            <!-- <div class="answer" v-html="entry.answer"></div> -->
                        </div>
                    </div>
                </div>
            </li>
            <?php
                };
            ?>
        </ul>
    </div>

</div>

<script>

    var faqApp = null;

    jQuery(document).ready(function ($) {
        
        faqApp = new Vue({
            el: '#faq',
            data: {
                categories: [],
                entries: [],
                searchText: '',
                selectedCategory: 'all',
                selectedEntry: null
            },
            computed: {
            },
            methods: {
                init: function () {

                    var categoryId = '';
                    var method = (categoryId) ? 'POST' : 'GET';
                    var data = (categoryId) ? JSON.stringify( { categoryId : categoryId } ) : null;

                    $.ajax({
                        url: PointComfort.API + '/api/faqs/',
                        // url: 'https://pcu-portal-api.azurewebsites.net/api/faqs/',
                        method: method,
                        data: data,
                        contentType: 'application/json'
                    }).done(function (result) {
                        if (result.success) {
                            faqApp.entries = result.data.entries;
                            faqApp.categories = result.data.categories;
                            var selectedCategory = $('#StartOnCategory').val();
                            if (selectedCategory) {
                                faqApp.selectCategory(selectedCategory);
                            }
                            $('.faq-list-container').fadeIn(500);
                            $('.faq-search').fadeIn(500);
                            $('.faq-categories-container').fadeIn(500);
                        } else {
                            console.log(result);
                            console.log('Call succeed, but result failed.');
                        }
                    }).fail(function () {
                        console.log('init failed.');
                    });
                    
                },
                matchesCategory: function (categories) {
                    var selectedCategory = this.selectedCategory;
                    if ('all' == selectedCategory)
                        return true;
                    return (null != $.findFirst(categories, function (category) {
                        return (category == selectedCategory);
                    }));
                },
                matchesSearch: function (title) {
                    return ((0 == this.searchText.length) || (title.toLowerCase().includes(this.searchText.toLowerCase())));
                },
                selectCategory: function (category, event) {
                    if (event)
                        event.preventDefault();
                    this.selectedCategory = category;
                },
                selectEntry: function (entry, event) {
                    if (event)
                        event.preventDefault();
                    if (this.selectedEntry != entry.id)
                        this.selectedEntry = entry.id;
                    else
                        this.selectedEntry = null;
                },
                isSelectedCategoryOrParentOfSelectedCategory: function (parentId) {
                    var selectedCategory = this.selectedCategory;
                    if (parentId == selectedCategory)
                        return true;
                    var parentCategory = $.findFirst(this.categories, function (c) {
                        return (c.id == parentId);
                    });
                    return (null != $.findFirst(parentCategory.children, function (c) {
                        return (c.id == selectedCategory);
                    }));
                },
                clearSearch: function (event) {
                    if (event)
                        event.preventDefault();
                    this.searchText = '';
                },
            }
        });

        faqApp.init();

    });

</script>

</div>
 </section>

<?php 
// };

get_footer(); ?>

