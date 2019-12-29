<table class="table">
    <tr>
      <td>Nama</td>
      <td>:</td>
      <td><?php echo $user->row()->name; ?></td>
    </tr>
    <tr>
      <td>Perusahaan</td>
      <td>:</td>
      <td><?php echo $user->row()->nama_perusahaan; ?></td>
    </tr>
    <tr>
      <td>Nomor</td>
      <td>:</td>
      <td><?php echo $user->row()->no_telp_pic; ?></td>
    </tr>
    <tr>
      <td>No. Fax</td>
      <td>:</td>
      <td><?php echo $user->row()->fax; ?></td>
    </tr>
</table>