<form name="left" action="" method="POST">

<ul>
<!--<tr><td><img width="180" src="images/leftmenu_top.png" alt="Top" />-->
<li><a class="menu_left" href="home.php?page=text.php"            >Home            			</a></li>
<li><a class="menu_left" href="home.php?page=enterts.php"         >Enter Time Sheet			</a></li>
<li><a class="menu_left" href="home.php?page=report.php"          >View Reports    			</a></li>
<li><a class="menu_left" href="home.php?page=displayproject.php"  >Display Projects			</a></li>
<li><a class="menu_left" href="home.php?page=enterbackdatets.php" >Retrospective Time Sheet </a></li>
<li><a class="menu_left" href="home.php?page=updatets.php" 		  >Update Time Sheet  		</a></li>

<?php
if($_SESSION['SESS_access']=='admin' || $_SESSION['SESS_access']=='manager')
{
echo "<li><a class=\"menu_left\" href=\"home.php?page=approvetimesheet.php\">Approve Time Sheet 	</a></li>";
echo "<li><a class=\"menu_left\" href=\"home.php?page=createproject.php\"   >Create Project			</a></li>";
echo "<li><a class=\"menu_left\" href=\"home.php?page=updateproject.php\"   >Update Project			</a></li>";
echo "<li><a class=\"menu_left\" href=\"home.php?page=nuser.php\"    >Create User			</a></li>";
//echo "<li><a class=\"menu_left\" href=\"home.php?page=updateuser.php\"    >Update User			</a></li>";
//echo "<li><a class=\"menu_left\" href=\"home.php?page=createtask.php\"    >Create Task			</a></li>";
//echo "<li><a class=\"menu_left\" href=\"home.php?page=deletetask.php\"    >Delete Task			</a></li>";
echo "<li><a class=\"menu_left\" href=\"home.php?page=createchargecode.php\">Create Charge Code 		</a></li>";
echo "<li><a class=\"menu_left\" href=\"home.php?page=deletechargecode.php\">Delete Charge Code 		</a></li>";
//echo "<li><a class=\"menu_left\" href=\"home.php?page=approvetimesheet1.php\">Approve Time Sheet 		</a></li>";
}
?>
<!--<tr><td><img width="180" src="images/leftmenu_bottom.png" alt="Bottom" />-->
</ul>
</form>
