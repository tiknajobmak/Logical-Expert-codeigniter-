<div class="partition-detail">
    <div class="hdng-bck hdng-segment-detail">
        <h3><?php echo isset($singleData['courseName']) ? $singleData['courseName'] : ''; ?>'s Detail</h3>   
        <div class="clearfix"></div>
    </div>
    <div class="update-text">
        <div class="seg-row">
            <label>Course Name</label>
            <div class="seg-data">
                <p><?php echo isset($singleData['courseName']) ? $singleData['courseName'] : ''; ?></p>
            </div>
        </div>
        <div class="seg-row">
            <label>Course Duration</label>
            <div class="seg-data">
                <p><?php echo isset($singleData['courseDuration']) ? $singleData['courseDuration'] : ''; ?></p>
            </div>
        </div>
        <div class="seg-row">
            <label>Created By</label>
            <div class="seg-data">
                <p><?php echo isset($singleData['userName']) ? $singleData['userName'] : ''; ?></p>
            </div>
        </div>
    </div>
</div>