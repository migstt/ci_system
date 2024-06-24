<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <div class="container-sm">
        <?php echo form_open('user/logout'); ?>
        <button type="submit" class="btn btn-success">Logout</button>
        </form>

        <h3><?php echo $current_user['user_first_name'] . ' ' . $current_user['user_last_name'] . "'s "; ?> contacts
        </h3>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewContactModal">
            Add new contact
        </button>
        <div>
            <!-- Search Input -->
            <div class="input-group mb-3 mt-3">
                <button class="btn btn-outline-primary dropdown-toggle" id="searchContactFilter" type="button" data-bs-toggle="dropdown" aria-expanded="false">Search by </button>
                <ul class="dropdown-menu">
                    <li onclick="showContactFilter(this)">Default: no filter</li>
                    <li onclick="showContactFilter(this)">Name</li>
                    <li onclick="showContactFilter(this)">Phone number</li>
                    <li onclick="showContactFilter(this)">Email</li>
                    <li onclick="showContactFilter(this)">Company</li>
                    <li onclick="showContactFilter(this)">Something else here</li>
                </ul>
                <input type="text" class="form-control" aria-label="Text input with dropdown button">
            </div>

            <!-- Contacts Table -->
            <table class="table table-sm mt-3" class="cssTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Company</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Email Address</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($contacts)) : ?>
                        <?php $counter = 1; ?>
                        <?php foreach ($contacts as $contacts_item) : ?>
                            <tr>
                                <td><?php echo $counter; ?></td>
                                <td><?php echo $contacts_item->contact_first_name . ' ' . $contacts_item->contact_last_name; ?>
                                </td>
                                <td><?php echo $contacts_item->contact_company_name; ?></td>
                                <td><?php echo $contacts_item->contact_phone; ?></td>
                                <td><?php echo $contacts_item->contact_email; ?></td>
                                <td>
                                    <div class="d-flex justify-content-end">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic mixed styles example">
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editContactModal<?php echo $contacts_item->contact_id; ?>">Edit</button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal<?php echo $contacts_item->contact_id; ?>">Delete</button>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#shareContactModal<?php echo $contacts_item->contact_id; ?>">Share</button>
                                        </div>
                                    </div>
                                </td>

                                <!-- Update/Edit Contact Modal -->
                                <?php echo validation_errors(); ?>
                                <?php echo form_open('contact/update_contact'); ?>
                                <div class="modal fade" id="editContactModal<?php echo $contacts_item->contact_id; ?>" tabindex="-1" aria-labelledby="editContactModal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Contact</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row g-3 mb-3">
                                                    <div class="col">
                                                        <input name="firstname" value=<?php echo $contacts_item->contact_first_name; ?> type="text" class="form-control" placeholder="First name" aria-label="First name" required />
                                                    </div>
                                                    <div class="col">
                                                        <input name="lastname" value=<?php echo $contacts_item->contact_last_name; ?> type="text" class="form-control" placeholder="Last name" aria-label="Last name" required />
                                                    </div>
                                                </div>
                                                <div class="row g-3 mb-3">
                                                    <div class="col">
                                                        <input name="email" value=<?php echo $contacts_item->contact_email; ?> type="email" class="form-control" placeholder="Email address" aria-label="Email address" required />
                                                    </div>
                                                    <div class="col">
                                                        <input name="phone" value=<?php echo $contacts_item->contact_phone; ?> type="text" class="form-control" placeholder="Phone number" aria-label="Phone number" required />
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <input name="companyname" value=<?php echo $contacts_item->contact_company_name; ?> type="text" class="form-control" placeholder="Company name" aria-label="Company name" required />
                                                </div>
                                                <div class="col">
                                                    <input type="hidden" name="contact_id" value=<?php echo $contacts_item->contact_id; ?> type="text" class="form-control" placeholder="contact_id" aria-label="contact_id" required />
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>

                                <!-- Delete Confirmation Modal -->
                                <?php echo validation_errors(); ?>
                                <?php echo form_open('contact/delete_contact'); ?>
                                <div class="modal fade" id="confirmDeleteModal<?php echo $contacts_item->contact_id; ?>" tabindex="-1" aria-labelledby="confirmDeleteModal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmation</h1>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="contact_id" value="<?php echo $contacts_item->contact_id; ?>" />
                                                <p>Are you sure you want to delete this contact?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger">Yes</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Nope</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>


                                <!-- Share Modal -->
                                <?php echo form_open('contact/share_contact'); ?>
                                <div class="modal fade" id="shareContactModal<?php echo $contacts_item->contact_id; ?>" tabindex="-1" aria-labelledby="shareContactModal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Share contact</h1>
                                                <div class="col">
                                                    <input type="hidden" name="contact_id" value=<?php echo $contacts_item->contact_id; ?> type="text" class="form-control" placeholder="contact_id" aria-label="contact_id" required />

                                                    <div class="row g-3 mb-3">
                                                        <div class="col">
                                                            <input type="hidden" name="firstname" value=<?php echo $contacts_item->contact_first_name; ?> type="text" class="form-control" placeholder="First name" aria-label="First name" required />
                                                        </div>
                                                        <div class="col">
                                                            <input type="hidden" name="lastname" value=<?php echo $contacts_item->contact_last_name; ?> type="text" class="form-control" placeholder="Last name" aria-label="Last name" required />
                                                        </div>
                                                    </div>
                                                    <div class="row g-3 mb-3">
                                                        <div class="col">
                                                            <input type="hidden" name="email" value=<?php echo $contacts_item->contact_email; ?> type="email" class="form-control" placeholder="Email address" aria-label="Email address" required />
                                                        </div>
                                                        <div class="col">
                                                            <input type="hidden" name="phone" value=<?php echo $contacts_item->contact_phone; ?> type="text" class="form-control" placeholder="Phone number" aria-label="Phone number" required />
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <input type="hidden" name="companyname" value=<?php echo $contacts_item->contact_company_name; ?> type="text" class="form-control" placeholder="Company name" aria-label="Company name" required />
                                                    </div>

                                                </div>
                                                <div>
                                                    <?php echo validation_errors(); ?>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="modal-body">
                                                    <?php if (!empty($user_options)) : ?>
                                                        <?php echo form_dropdown('user_selected', $user_options, 'Default'); ?>
                                                    <?php else : ?>
                                                        <p>No users to share with found.</p>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Share</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </tr>
                            <?php $counter++; ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6">No contacts found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <p><?php echo $links; ?></p>

            <!-- Add New Contact Modal -->
            <div class="modal fade" id="addNewContactModal" tabindex="-1" aria-labelledby="addNewContactModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Contact</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php echo validation_errors(); ?>
                            <?php echo form_open('contact/insert_contact'); ?>
                            <div class="row g-3 mb-3">
                                <div class="col">
                                    <input name="firstname" value="<?php echo set_value('firstname'); ?>" type="text" class="form-control" placeholder="First name" aria-label="First name" required />
                                </div>
                                <div class="col">
                                    <input name="lastname" value="<?php echo set_value('lastname'); ?>" type="text" class="form-control" placeholder="Last name" aria-label="Last name" required />
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col">
                                    <input name="email" value="<?php echo set_value('email'); ?>" type="email" class="form-control" placeholder="Email address" aria-label="Email address" required />
                                </div>
                                <div class="col">
                                    <input name="phone" value="<?php echo set_value('phone'); ?>" type="text" class="form-control" placeholder="Phone number" aria-label="Phone number" required />
                                </div>
                            </div>
                            <div class="col">
                                <input name="companyname" value="<?php echo set_value('companyname'); ?>" type="text" class="form-control" placeholder="Company name" aria-label="Company name" required />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>