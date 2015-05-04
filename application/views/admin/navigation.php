<style type="text/css">
    /**
     * Nestable
     */
    .dd { position: relative; display: block; margin: 0; padding: 0; max-width: 600px; list-style: none; font-size: 13px; line-height: 20px; }

    .dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
    .dd-list .dd-list { padding-left: 30px; }
    .dd-collapsed .dd-list { display: none; }

    .dd-item,
    .dd-empty,
    .dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }

    .dd-handle { display: block; height: 30px; margin: 5px 0; padding: 5px 10px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
                 background: #fafafa;
                 background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
                 background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
                 background:         linear-gradient(top, #fafafa 0%, #eee 100%);
                 -webkit-border-radius: 3px;
                 border-radius: 3px;
                 box-sizing: border-box; -moz-box-sizing: border-box;
    }
    .dd-handle:hover { color: #2ea8e5; background: #fff; }

    .dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 5px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
    .dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0; }
    .dd-item > button[data-action="collapse"]:before { content: '-'; }

    .dd-placeholder,
    .dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
    .dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5;
                background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                    -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
                background-image:    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
                background-image:         linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                    linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
                background-size: 60px 60px;
                background-position: 0 0, 30px 30px;
    }

    .dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
    .dd-dragel > .dd-item .dd-handle { margin-top: 0; }
    .dd-dragel .dd-handle {
        -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
        box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
    }

    /*
     * Nestable Extras
     */
    .nestable-lists { display: block; clear: both; padding: 30px 0; width: 100%; border: 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; }
    #nestable-menu { padding: 0; margin: 20px 0; }
    @media only screen and (min-width: 700px) {

        .dd { float: left; width: 48%; }
        .dd + .dd { margin-left: 2%; }

    }

    .dd-hover > .dd-handle { background: #2ea8e5 !important; }

    /**
     * Nestable Draggable Handles
     */

    .dd3-content { display: block; height: 30px; margin: 5px 0; padding: 5px 10px 5px 40px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
                   background: #fafafa;
                   background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
                   background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
                   background:         linear-gradient(top, #fafafa 0%, #eee 100%);
                   -webkit-border-radius: 3px;
                   border-radius: 3px;
                   box-sizing: border-box; -moz-box-sizing: border-box;
    }
    .dd3-content:hover { color: #2ea8e5; background: #fff; }

    .dd-dragel > .dd3-item > .dd3-content { margin: 0; }

    .dd3-item > button { margin-left: 30px; }

    .dd3-handle { position: absolute; margin: 0; left: 0; top: 0; cursor: pointer; width: 30px; text-indent: 100%; white-space: nowrap; overflow: hidden;
                  border: 1px solid #aaa;
                  background: #ddd;
                  background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
                  background:    -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
                  background:         linear-gradient(top, #ddd 0%, #bbb 100%);
                  border-top-right-radius: 0;
                  border-bottom-right-radius: 0;
    }
    .dd3-handle:before { content: '≡'; display: block; position: absolute; left: 0; top: 3px; width: 100%; text-align: center; text-indent: 0; color: #fff; font-size: 20px; font-weight: normal; }
    .dd3-handle:hover { background: #ddd; }

</style>
<!-- content-part starts -->
<div class="content-part">
    <div class="container-fluid">
        <!-- row starts -->
        <div class="row">
            <!-- content -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h4><?php echo ($heading) ? $heading : ''; ?></h4>
                <!-- first-part starts -->
                <?php
                // Generate your multidimensional array from the linear array
                function GenerateNavArray($arr, $parent = 0) {
                    $pages = Array();
                    foreach ($arr as $page) {
                        if ($page['parentId'] == $parent) {
                            $page['sub'] = isset($page['sub']) ? $page['sub'] : GenerateNavArray($arr, $page['pageId']);
                            $pages[] = $page;
                        }
                    }
                    return $pages;
                }
                // loop the multidimensional array recursively to generate the HTML
                function GenerateNavHTML($nav) {
                    $html = '<ol class="dd-list">';
                    foreach ($nav as $page) {
                        $html .= '<li class="dd-item" data-id="' . $page['pageId'] . '">';
                        $html .= '<div class="dd-handle">' . $page['title'] . '</div>';
                        $html .= GenerateNavHTML($page['sub']);
                        $html .= '</li>';
                    }
                    $html .= "</ol>";
                    return $html;
                }
                $navarray = GenerateNavArray($userData);
                ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="dd" id="nestable">
                        <?php echo GenerateNavHTML($navarray); ?>
                    </div>
                </div>
                <!-- first-part ends -->
            </div>
            <!-- row ends -->
        </div>
    </div>
    <!-- content-part ends -->
</div>
<!-- right-content ends -->
<div class="clearfix"></div>
</div>
<?php echo (isset($js)) ? $js : ''; ?>
<script>
    jQuery(document).ready(function() {
        jQuery('#nestable').nestable().on('change', function() {
            var str = JSON.stringify(jQuery('#nestable').nestable('serialize'));
            var jsonEncode = {menu: str};
            callAjax(jsonEncode, 'navigations/changeMenu', useBaseUrl = 1);
        });
    });
</script>
</body>
</html>