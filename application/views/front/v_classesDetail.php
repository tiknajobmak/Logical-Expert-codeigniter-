<div class="partition-detail">
<div class="hdng-bck hdng-segment-detail">
<h3><?php echo isset($singleData['className']) ? $singleData['className']: ''; ?>'s Detail</h3>   

<div class="clearfix"></div>
</div>
<div class="update-text">
    <div class="seg-row">
        <label>Class Name</label>
        <div class="seg-data">
            <p><?php echo isset($singleData['className']) ? $singleData['className'] : ''; ?></p>
        </div>
    </div>
    <div class="seg-row">
        <label>Class Start Date</label>
        <div class="seg-data">
            <p><?php echo isset($singleData['startDate']) ? $singleData['startDate']: ''; ?></p>
        </div>
    </div>    
    <div class="seg-row">
        <label>Class End Date</label>
        <div class="seg-data">
            <p><?php echo isset($singleData['endDate']) ? $singleData['endDate']: ''; ?></p>
        </div>
    </div>
    <div class="seg-row">
        <label>Class Duration</label>
        <div class="seg-data">
            <p><?php echo isset($singleData['duration']) ? $singleData['duration']: ''; ?></p>
        </div>
    </div>
    <div class="seg-row">
        <label>Class Time</label>
        <div class="seg-data">
            <p><?php echo isset($singleData['time']) ? $singleData['time']: ''; ?></p>
        </div>
    </div>
    <div class="seg-row">
        <label>Class Price</label>
        <div class="seg-data">
            <p><?php echo isset($singleData['price']) ? $singleData['price']: ''; ?></p>
        </div>
    </div>
    <div class="seg-row">
        <label>Class Type</label>
        <div class="seg-data">
            <p><?php echo isset($singleData['classType']) ? $singleData['classType']: ''; ?></p>
        </div>
    </div>
    <div class="seg-row">
        <label>Class Payment Type</label>
        <div class="seg-data">
            <p><?php echo isset($singleData['paymentType']) ? $singleData['paymentType']: ''; ?></p>
        </div>
    </div>
    <div class="seg-row">
        <label>Created By</label>
        <div class="seg-data">
            <p><?php echo isset($singleData['userName']) ? $singleData['userName']: ''; ?></p>
        </div>
    </div>
    <div class="seg-row">
        <label>Course Name</label>
        <div class="seg-data">
            <p><?php echo isset($singleData['courseName']) ? $singleData['courseName']: ''; ?></p>
        </div>
    </div>
</div>
</div>