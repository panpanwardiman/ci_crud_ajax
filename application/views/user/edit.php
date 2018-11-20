<div id="body">
	<?php echo form_open('user/update/'.$user->id, 'id="form"') ?>
		<table>
			<tr>
				<td>Username</td>
				<td>
					<input type="text" name="username" value="<?php echo set_value('username', $user->username) ?>">
					<?php echo form_error('username', '<i style="font-size: 12px;">', '</i>') ?>
				</td>
			</tr>
			<tr>
				<td>Role</td>
				<td>
					<select name="role_id">
						<option value=""></option>
						<?php foreach ($roles as $role): ?>
							<option value="<?php echo $role->id ?>"
							<?php echo ($user->role_id == $role->id) ? 'selected':''; ?>
							><?php echo $role->role ?></option>
						<?php endforeach ?>
					</select>
					<?php echo form_error('role_id', '<i style="font-size: 12px;">', '</i>') ?>
				</td>
			</tr>
		</table>
	</form>
</div>