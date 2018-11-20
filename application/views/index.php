<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
        text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}

    .table {
        border-collapse: collapse;
        width: 100%;
    }

    .table th, .table td {
        border: 1px solid #D0D0D0;
        padding: 8px;
        text-align: left;
    }

    .table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

	#paging a {
		padding: 0 5px;
	}

	.container-table {
		width: 40%;
	}

	.blockah {
		display: none;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>
		<a href="<?php echo site_url('/') ?>">User</a> |
        <a href="<?php echo site_url('role') ?>">Role</a> |
        <a href="<?php echo site_url('permission') ?>">Permission</a> |
        <a href="<?php echo site_url('') ?>">Setting User Permission</a>
		<span style="float: right"><a href="<?php echo site_url('auth/logout') ?>">Logout</a></span>
	</h1>
	
    <?php $this->load->view($content) ?>

	<p class="footer">
        Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?>
    </p>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<script>
	$(document).ready(function(){
		$('#simpan').click(function(){
			save();
		});

		$('input[name=search]').focus(function(){
			$('.blockah').css('display', 'block');
		});

		$('.blockah').click(function(){
			$('.blockah').css('display', 'none');
		});

		$('#paging').on('click', 'a', function(e) {
			e.preventDefault(); 
			var page = $(this).attr('data-ci-pagination-page');
			pagination(page);
		});
	});
	function pagination(page) {
		$.ajax({			
			url: '<?php echo site_url() ?>user/pagination/'+page,
			type: 'GET',
			dataType: "json",
			success: function(data) {
				userTable(data.user_table, data.start);
				$('#paging').html(data.paging);				
				start = Number(data.start);
				var first = start + 1;
				var second = start + 5;
				if (second > data.user_table.length) {
					second = data.total_rows;
				}
				var html = first+' to '+ second +' of '+ data.total_rows +' entries';
				$('#total_rows').html(html);
			}
		});
	}

	pagination(0);

	function userTable(user_table, start) {
		no = Number(start);
		$('#show_data').empty();
		var html = '';
		for (i in user_table) {
			no += 1;
			html += '<tr>';
				html += '<td>'+ no +'</td>';
				html += '<td>'+ user_table[i].username +'</td>';
				html += '<td>'+ user_table[i].role +'</td>';
				html += '<td><button type="button" onclick="hapus(this)" data-id="'+ user_table[i].id +'">Delete</button></td>';
			html += '</tr>';
		}
		$('#show_data').append(html);
	}

	function save() {
		var username = $("input[name='username']").val();
		var role = $("select[name='role_id']").val();
		var password = $("input[name='password']").val();
		var password_confirm = $("input[name='password_confirm']").val();
		
		$.ajax({
			type: 'POST',
			url: '<?php echo site_url('user/store') ?>',
			data: { username: username, role_id: role, password: password, password_confirm: password_confirm },
			dataType: 'JSON',
			success: function(data) {
				$("input[name='username']").val("");
				$("select[name='role_id']").val("");
				$("input[name='password']").val("");
				$("input[name='password_confirm']").val("");
				toastr.success('Data berhasil dihapus!', 'Sukses', {
					timeOut: 20000,
					closeButton: true,
					progressBar: true
				});
				pagination(1);

			}
		});
	}

	function hapus(el) {
		// console.log(id);
		var id = $(el).data('id');
		var confirmation = confirm('Anda yakin?');

		if (confirmation) {
			$.ajax({
				type: 'POST',
				url: '<?php echo site_url('user/destroy') ?>',
				data: { id: id },
				dataType: 'JSON',
				success: function(data) {
					// show_data();
					toastr.success('Data berhasil dihapus!', 'Sukses', {
						timeOut: 20000,
						closeButton: true,
						progressBar: true
					});
					show_data(1);
				}
			});
		}
	}

	function search() {
		var keyword = $('input[name=search]').val();
		
		if (keyword != '') {
			$.ajax({
				type: 'POST',
				url: '<?php echo site_url('user/search') ?>',
				data: {keyword: keyword},
				dataType: 'json',
				success: function(data) {
					var html = "";
					var i;
					var j = 0;
					if (data.length > 0) {
						for (i = 0; i < data.length; i++) {
							html += '<tr>';
								html += '<td>'+ ++j +'</td>';
								html += '<td>'+ data[i].username +'</td>';
								html += '<td>'+ data[i].role +'</td>';
								html += '<td><button type="button" id="selected" data-id="'+ data[i].id +'" onClick="hapus(this)">Delete</button></td>';
							html += '</tr>';
						}
					} else {
						html += '<tr>';
							html += '<td colspan="4">Tidak ada data.</td>';
						html += '</tr>';
					}
					$('#show_data').html(html);
				}
			});
		} else {
			pagination(0);
		}
	}

</script>
</body>
</html>