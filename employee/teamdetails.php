<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/dbconnection.php');

if (!isset($_SESSION['empid']) || strlen($_SESSION['empid']) == 0) {
    header('location:logout.php');
    exit();
}

$empid = $_SESSION['empid'];

$sql = "SELECT 
    t.TeamId, 
    tk.TaskTitle, 
    t.StartDate, 
    t.EndDate, 
    e_leader.EmpName AS LeaderName, 
    e_leader.ProfilePic AS LeaderPic,
    COALESCE(GROUP_CONCAT(DISTINCT e_member.EmpName), 'No Members') AS Members, 
    COALESCE(GROUP_CONCAT(DISTINCT e_member.ProfilePic), 'default.jpg') AS MemberPics,
    COALESCE(GROUP_CONCAT(DISTINCT e_member.Designation), 'Not Assigned') AS MemberDesignations
FROM tblteam t
JOIN tbltask tk ON t.TaskId = tk.ID
JOIN tblemployee e_leader ON t.LeaderId = e_leader.EmpId
LEFT JOIN tblteammembers tm ON t.TeamId = tm.TeamId
LEFT JOIN tblemployee e_member ON tm.MemberId = e_member.EmpId
WHERE t.LeaderId = :empid OR EXISTS (
    SELECT 1 FROM tblteammembers m WHERE m.TeamId = t.TeamId AND m.MemberId = :empid
)
GROUP BY t.TeamId, tk.TaskTitle, t.StartDate, t.EndDate, e_leader.EmpName, e_leader.ProfilePic";

$query = $dbh->prepare($sql);
$query->bindParam(':empid', $empid, PDO::PARAM_INT);
$query->execute();
$teams = $query->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Employee Management System | Team Management</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <style>
/* Team Box */
.team-box {
    border-radius: 12px;
    padding: 15px;
    background: white;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.team-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
}

/* Profile Pics */
.profile-pic {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #dee2e6;
    transition: transform 0.3s ease;
}

.leader .profile-pic {
    border-color: #007bff;
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
}

.member .profile-pic {
    border-color: #6c757d;
}

.member:hover .profile-pic {
    transform: scale(1.05);
}

/* Name Styling */
.leader-name, .member-name {
    font-size: 15px;
    font-weight: 600;
    margin-top: 8px;
    color: #343a40;
}

.member-name small {
    font-weight: 400;
    font-size: 13px;
    color: #6c757d;
}

/* Members Section */
.members h5 {
    font-size: 16px;
    margin-bottom: 15px;
    color: #495057;
    font-weight: 600;
}

.members .d-flex {
    display: flex;
    flex-wrap: wrap; /* Prevent wrapping */
    gap: 15px;
    overflow-x: auto;  /* Enable horizontal scroll if necessary */
    justify-content: center;
    padding-bottom: 10px;
}

/* Hide scrollbar in WebKit (Chrome, Safari) */
.members .d-flex::-webkit-scrollbar {
    display: none;
}

/* Optional: Hide scrollbar in Firefox */
.members .d-flex {
    scrollbar-width: none;
}

/* Member styling to fit better inline */
.member {
    flex: 0 0 auto;
    width: 110px;
    text-align: center;
}


/* Responsive grid tweaks */
@media (max-width: 768px) {
    .team-box {
        margin-bottom: 20px;
    }
}
    </style>
</head>
<body class="inner_page tables_page">
<div class="full_container">
    <div class="inner_container">
        <?php include_once('includes/sidebar.php'); ?>
        <div id="content">
            <?php include_once('includes/header.php'); ?>
            <div class="midde_cont">
                <div class="container-fluid">
                    <div class="row column_title">
                        <div class="col-md-12">
                            <div class="page_title">
                                <h2>Team Management</h2>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <?php if (count($teams) > 0) { ?>
                            <?php foreach ($teams as $team) { ?>
                                <div class="col-6">

                                    <div class="team-box text-center">
                                        <h4><?php echo htmlentities($team->TaskTitle); ?></h4>
                                        <p><strong>Start:</strong> <?php echo htmlentities($team->StartDate); ?> | 
                                           <strong>End:</strong> <?php echo htmlentities($team->EndDate); ?></p>

                                        <!-- Leader Profile -->
                                        <div class="leader">
                                            <img src="<?php echo !empty($team->LeaderPic) ? '../admin/images/' . htmlentities($team->LeaderPic) : 'admin/images/default.jpg'; ?>" class="profile-pic" alt="Leader">
                                            <p class="leader-name"><?php echo htmlentities($team->LeaderName); ?> (Leader)</p>
                                        </div>

                                        <hr>

                                        <!-- Members -->
                                        <div class="members">
                                            <h5>Members:</h5>
                                            <div class="d-flex">
                                                <?php
                                                $memberNames = !empty($team->Members) ? explode(',', $team->Members) : [];
                                                $memberPics = !empty($team->MemberPics) ? explode(',', $team->MemberPics) : [];
                                                $memberDesignations = !empty($team->MemberDesignations) ? explode(',', $team->MemberDesignations) : [];

                                                for ($i = 0; $i < count($memberNames); $i++) {
                                                    $pic = !empty($memberPics[$i]) && file_exists("../admin/images/" . $memberPics[$i]) 
                                                        ? $memberPics[$i] 
                                                        : 'default.jpg';
                                                ?>
                                                    <div class="member">
                                                        <img src="../admin/images/<?php echo htmlentities($pic); ?>" class="profile-pic" alt="<?php echo htmlentities($memberNames[$i]); ?>">
                                                        <p class="member-name">
                                                            <?php echo htmlentities($memberNames[$i]); ?><br>
                                                            <small>(<?php echo htmlentities($memberDesignations[$i]); ?>)</small>
                                                        </p>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <div class="col-md-12 text-center">
                                <p>No teams found.</p>
                            </div>
                        <?php } ?>
                    </div>

                    <?php include_once('includes/footer.php'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
