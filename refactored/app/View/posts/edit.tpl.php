<h2>Edit listtbl data</h2>

<p>Hello <?= $username; ?>!</p>
<a href="users/logout">Click here to logout.</a>
<br/>
<br/>
<a href="users/home">Return to user Home Page.</a>
<h2 align="center">Currently Selected Record</h2>

<?php if ($post): ?>
  <table border="1px" width="100%">
    <tr>
      <th>ID</th>
      <th>Details</th>
      <th>Post Time</th>
      <th>Edit Time</th>
      <th>Public Post</th>
    </tr>

      <tr>
        <td align="center"><?= $post->id; ?></td>
        <td align="center"><?= $post->details; ?></td>
        <td align="center"><?= $post->postDate . " - " . $post->postTime; ?></td>
        <td align="center"><?= $post->editDate . " - " . $post->editTime; ?></td>
        <td align="center"><?= $post->isPublic; ?></td>
      </tr>

  </table>
  <br/>

  <form action="posts/edit" method="POST">
    Enter new detail:
    <input type="text" name="details" />
    <br/> Public post?
    <input type="checkbox" name="public" value="yes" />
    <br/>
    <input type="submit" value="Update list" />
  </form>
<?php else: ?>
  <h2 align="center">There is no data to be edited.</h2>
<?php endif; ?>
