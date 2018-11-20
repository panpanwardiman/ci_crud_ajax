<div id="body">
	<!-- <a href="<?php echo site_url('user/create') ?>">New Users</a> -->
	<!-- <?php echo form_open('user/store') ?> -->
	<form>
		<table>
			<tr>
				<td>Username</td>
				<td>
					<input type="text" name="username" value="<?php echo set_value('username') ?>">
					<?php echo form_error('username', '<i style="font-size: 12px;">', '</i>') ?>
				</td>
			</tr>
			<tr>
				<td>Role</td>
				<td>
					<select name="role_id">
						<option value=""></option>
						<?php foreach ($roles as $role): ?>
							<option value="<?php echo $role->id ?>"><?php echo $role->role ?></option>
						<?php endforeach ?>
					</select>
					<?php echo form_error('role_id', '<i style="font-size: 12px;">', '</i>') ?>
				</td>
			</tr>
			<tr>
				<td>Password</td>
				<td>
					<input type="password" name="password">
					<?php echo form_error('password', '<i style="font-size: 12px;">', '</i>') ?>
				</td>
			</tr>
			<tr>
				<td>Password Confirmation</td>
				<td>
					<input type="password" name="password_confirm">
					<?php echo form_error('password_confirm', '<i style="font-size: 12px;">', '</i>') ?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><button type="button" id="simpan">Save</button></td>
			</tr>
		</table>
	</form>

	<br>
	Search: <input type="text" name="search" onkeyup="search()" autocomplete="off">
	<div class="blockah">
		<div style="width: 200px; height: auto; border: 1px solid #000000; z-index: 9999; position: relative; left: 48px; margin-top:2px;">
			Lorem ipsum dolor, sit amet consectetur adipisicing elit. Laborum eaque delectus qui rem consequatur. Nam, earum iure? Quis perferendis perspiciatis fuga reiciendis, repellat sit atque, exercitationem dolorum voluptates minima dignissimos?
		</div>
	</div>
	<div class="container-table">
		<table class="table" style="margin-top: 10px;">
			<thead>
				<tr> 
					<th>No</th>   
					<th>Username</th>
					<th>Role</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody id="show_data">
			</tbody>
		</table>
		<div id="total_rows" style="float:left;"></div>
		<div id="paging" style="float:right"></div>
	</div>

	
	<!-- <div style='margin-top: 10px;' id='pagination'></div> -->
</div>