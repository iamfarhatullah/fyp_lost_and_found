<div class="row g-4">
    <div class="col-lg-5 col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="p-1 mt-3" style="background-color: #046fa3;">
                    <h2 class="text-white mt-2">Send Us a Message</h2>
                </div>
                <br />
                <form action="" id="inquiry-form">
                    <input type="hidden" name="id">
                    <input type="hidden" name="visitor">

                    <div class="mb-3">
                        <label for="fullname" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter your name" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" required>
                    </div>

                    <div class="mb-3">
                        <label for="contact" class="form-label">Contact No.</label>
                        <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter your contact number" required>
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea rows="5" class="form-control" id="message" name="message" placeholder="Enter your message in detail" required></textarea>
                    </div>

                    <div class="d-grid col-md-8 col-lg-6 " style="float: right;">
                        <button type="submit" class="btn btn-success"><i class="bi bi-send"></i> Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-7 col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class=" p-1 mt-3" style="background-color: #046fa3;">
                    <h2 class="text-white mt-2">Contact/Visit Us at:</h2>
                </div>
                <br />
                <dl class="mb-0">
                    <dt class="mb-2"><strong>Email us:</strong></dt>
                    <dd class="ps-3 mb-3"><?= $_settings->info('email') ?></dd><br>

                    <dt class="mb-2"><strong>Phone #:</strong></dt>
                    <dd class="ps-3 mb-3"><?= $_settings->info('phone') ?></dd><br>

                    <dt class="mb-2"><strong>Mobile #:</strong></dt>
                    <dd class="ps-3"><?= $_settings->info('mobile') ?></dd><br>

                    <dt class="mb-2"><strong>Office:</strong></dt>
                    <dd class="ps-3 mb-3"><?= $_settings->info('address') ?></dd><br>
                </dl>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#inquiry-form').submit(function(e) {
            e.preventDefault();
            const _this = $(this);
            $('.err-msg').remove();

            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_inquiry",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                dataType: 'json',
                error: err => {
                    console.error(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (resp?.status === 'success') {
                        location.replace('./?page=contact');
                    } else if (resp.status === 'failed' && resp.msg) {
                        const el = $('<div>').addClass("alert alert-danger err-msg").text(resp.msg);
                        _this.prepend(el);
                        $("html, body").scrollTop(0);
                        end_loader();
                    } else {
                        alert_toast("An error occurred", 'error');
                        end_loader();
                    }
                }
            });
        });
    });
</script>