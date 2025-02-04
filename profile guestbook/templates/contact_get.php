<section>
    <h2>Leave a Public Note/Question</h2>
    <form action="" method="post">
        <!-- CSRF -->
        <input type="hidden" name="csrf_token" value="<?= $data['csrfToken'] ?>">
        <label for="name">Name</label>
        <input type="text" name="name" id="name">
        <label for="email">Email</label>
        <input type="email" name="email" id="email">
        <label for="message">Message</label>
        <textarea name="message" id="message"></textarea>
        <button type="submit">Submit</button>
    </form>
</section>