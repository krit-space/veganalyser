<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<script>
    jQuery(document).ready(function (a) {
    "use strict";
            // Listen for click on toggle checkbox   
            jQuery( "body" ).on( "click", "#pselectall", function() {
                // Iterate each checkbox
                jQuery(':checkbox').each(function () {
                    this.checked = true;
                });
            });
             jQuery( "body" ).on( "click", "#punselectall", function() {
                // Iterate each checkbox
                jQuery(':checkbox').each(function () {
                    this.checked = false;
                });
            });
        });
</script>
<div class="pipe-main-box">
    <div class="tool-box bg-white p-20p pipe-view">
        <h3 class="title" style="font-size: 1.3em !important;font-weight: 600;"><?php _e('Export Settings', 'product-import-export-for-woo'); ?></h3>
        <p><?php _e('Export and download your products in CSV file format. This file can be used to import products back into your WooCommerce store.', 'product-import-export-for-woo'); ?></p>
        <form action="<?php echo admin_url('admin.php?page=wf_woocommerce_csv_im_ex&action=export'); ?>" method="post">
            <table class="form-table">
                <tr>
                    <th>
                        <label for="v_offset"><?php _e('Offset', 'product-import-export-for-woo'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="offset" id="v_offset" placeholder="0" class="input-text" />
                        <p style="font-size: 12px"><?php _e('Number of products to skip before exporting. If the value is 0 no products are skipped. If value is 100, products from product id 101 will be exported.', 'product-import-export-for-woo'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="v_limit"><?php _e('Limit', 'product-import-export-for-woo'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="limit" id="v_limit" placeholder="<?php _e('Unlimited', 'product-import-export-for-woo'); ?>" class="input-text" />
                        <p style="font-size: 12px"><?php _e('Number of products to export. If no value is given all products will be exported. This is useful if you have large number of products and want to export partial list of products.', 'product-import-export-for-woo'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="v_prods"><?php _e('Products', 'product-import-export-for-woo'); ?></label>
                    </th>
                    <td>
                        <select class="wc-product-search" multiple="multiple" id="v_prods" name="products[]" data-placeholder="<?php esc_attr_e('All Products', 'product-import-export-for-woo'); ?>"></select>

                        <p style="font-size: 12px"><?php _e('Filter the products to be exported', 'product-import-export-for-woo'); ?></p>
                    </td>
               </tr>

                <tr>
                    <th>
                        <label for="v_prod_categories"><?php _e('Product Categories', 'product-import-export-for-woo'); ?></label>
                    </th>
                    <td>
                        <!--<select class="wc-category-search" multiple="multiple" style="width: 40%;"  name="prod_categories[]" data-placeholder="<?php //esc_attr_e('Search for a category&hellip;', 'wf_csv_import_export');  ?>"></select>-->

                        <select id="v_prod_categories" name="prod_categories[]" data-placeholder="<?php _e('Any Category', 'wf_csv_import_export'); ?>" class="wc-enhanced-select" multiple="multiple">
                            <?php
                            //$product_categories = get_terms('product_cat', array('fields' => 'id=>name'));
                            $product_categories = get_terms('product_cat');
                            foreach ($product_categories as $category) {
                                echo '<option value="' . $category->term_id . '">' . ( ( get_bloginfo('version') < '4.8') ? $category->name : get_term_parents_list($category->term_id, 'product_cat', array('separator' => ' -> ')) ) . '</option>';
                            }
                            ?>
                        </select>

                        <p style="font-size: 12px"><?php _e('Filter the products to be exported by categories', 'product-import-export-for-woo'); ?></p>
                    </td>
                </tr>  

                <tr>
                    <th>
                        <label for="v_prod_tags"><?php _e('Product Tags', 'product-import-export-for-woo'); ?></label>
                    </th>
                    <td>
                        <select id="v_prod_tags" name="prod_tags[]" data-placeholder="<?php _e('Any Tag', 'product-import-export-for-woo'); ?>" class="wc-enhanced-select" multiple="multiple">
                            <?php
                            $product_tags = get_terms('product_tag');
                            foreach ($product_tags as $tag) {
                                echo '<option value="' . $tag->term_id . '">' . $tag->name . '</option>';
                            }
                            ?>
                        </select>
                        <p style="font-size: 12px"><?php _e('Filter the products to be exported by tags', 'product-import-export-for-woo'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="v_prod_status"><?php _e('Product Status', 'product-import-export-for-woo'); ?></label>
                    </th>
                    <td>
                        <?php $prod_status = array('publish', 'private', 'draft', 'pending', 'future') ?>
                        <select id="v_prod_status" multiple name="prod_status[]" data-placeholder="<?php _e('All Status', 'product-import-export-for-woo'); ?>" class="wc-enhanced-select" multiple="multiple">
                            <?php
                            foreach ($prod_status as $type_name) {
                                echo '<option value="' . $type_name . '">' . ucwords($type_name) . '</option>';
                            }
                            ?>
                        </select>

                        <p style="font-size: 12px"><?php _e('Filter the products to be exported by Post status', 'product-import-export-for-woo'); ?></p>
                    </td>
                </tr>   
                <tr>
                    <th colspan="2">
                        <label for="v_columns"><?php _e('Columns', 'product-import-export-for-woo'); ?></label>
                        <p style="font-size: 12px;font-weight:300;"><?php _e('Configure the Column Names of CSV file.', 'product-import-export-for-woo'); ?></p>
                    </th>
                <table id="datagrid">
                    <th style="text-align: left; padding:6px 25px !important; font-weight: normal !important;color:#000;">
                        <label for="v_columns"><?php _e('WooCommerce product field name', 'product-import-export-for-woo'); ?></label>
                    </th>
                    <th style="text-align: left; padding:6px 25px !important; font-weight: normal !important;color:#000;">
                        <label for="v_columns_name"><?php _e('Column header name in the CSV file', 'product-import-export-for-woo'); ?></label>
                    </th>
                    <!-- select all boxes -->
                        <tr>
                            <td style="padding: 10px;">
                                <a href="#" id="pselectall" onclick="return false;" ><?php _e('Select all', 'product-import-export-for-woo'); ?></a> &nbsp;/&nbsp;
                                <a href="#" id="punselectall" onclick="return false;"><?php _e('Unselect all', 'product-import-export-for-woo'); ?></a>
                            </td>
                        </tr>
                    <?php                   
                    $post_columns['product_page_url'] = 'product_page_url';
                    $post_columns['images'] = 'Images (featured and gallery)';
                    $post_columns['file_paths'] = 'Downloadable file paths';
                    $post_columns['taxonomies'] = 'Taxonomies (cat/tags/shipping-class)';
                    $post_columns['attributes'] = 'Attributes';
                    ?>
                    <?php foreach ($post_columns as $pkey => $pcolumn) {
                        ?>
                        <tr>
                            <td>
                                <input name= "columns[<?php echo $pkey; ?>]" type="checkbox" value="<?php echo $pkey; ?>" checked>
                                <label for="columns[<?php echo $pkey; ?>]"><?php _e($pcolumn, 'product-import-export-for-woo'); ?></label>
                            </td>
                            <td>
                                <?php
                                $tmpkey = $pkey;
                                if (strpos($pkey, 'yoast') === false) {
                                    $tmpkey = ltrim($pkey, '_');
                                }
                                ?>
                                <input type="text" name="columns_name[<?php echo $pkey; ?>]"  value="<?php echo $tmpkey; ?>" class="input-text" />
                            </td>
                        </tr>
                    <?php } ?>

                </table><br/>
                </tr>
            </table>
            <p class="submit"><input type="submit" class="button button-primary" value="<?php _e('Export Products', 'product-import-export-for-woo'); ?>" /></p>
            <p><span><i><?php _e('With this version of the plugin you can export products (except variable products) in to a file. If you want to export to an FTP location (scheduled / manual ) you may need to upgrade to premium version.', 'product-import-export-for-woo'); ?></i></span></p>
        </form>
    </div>
    <?php include(WF_ProdImpExpCsv_BASE . 'includes/views/market.php'); ?>
<div class="clearfix"></div>
</div>