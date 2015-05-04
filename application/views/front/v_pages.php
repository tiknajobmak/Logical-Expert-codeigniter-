<section>
    <div class="inner-page-cont">
        <div class="container">
            <?php
            echo (isset($pageData['title'])) ? '<h1>' . $pageData['title'] . '</h1>' : '';
            ?>
            <div class="entry-content">
                <?php
            echo (isset($pageData['content'])) ?  $pageData['content'] : '';
                ?>
                <div class="form-sec">
                    <form role="form">
                        <div class="form-group">
                            <label for="email">Email address:</label>
                            <input type="email" class="form-control" id="email">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Password:</label>
                            <input type="password" class="form-control" id="pwd">
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox"> Remember me</label>
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
