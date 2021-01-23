$(document).ready(function() {

    //var user.current_userID = null;
    var currentUserId;
    // /login

    function callback(response){
        currentUserId = response;
        console.log(currentUserId);
    }

    var user = {
        logIn: function(username, password){
            var current_user = {
                username: username,
                password: password
            };
            $.ajax({
                type: "POST",
                data:{ data: current_user, action: 'logIn'},
                url: "php/authenticate.php",
                success:function(data){
                    callback(data);
                    location.href = "home.php";
                    Note.get(currentUserId);
                    
                }
            })
        }
    };

    $('#logIn').click(function(){
        if($('#username').val()==="" || $('#password').val()===""){
            alert('please complete the form');
        }
        else if($('#username').val()!="" && $('#password').val()!=""){
            user.logIn($('#username').val(), $('#password').val());
            // alert($('#password').val());
            $('#username').val(""); 
            $('#password').val("");
        }
            
    });

    var Note = {
            
        add: function(name, description,userID) {
            console.log(name, description);
            var new_note = {
                name: name,
                description: description,
                userID: userID
            };

            $.ajax({
                type: "POST",
                data: { data: new_note, action: 'add_note' },
                url: "php/Note.php",
                success: function(data) {
                    Note.get(currentUserId);
                    $("#addNoteModal").modal("hide");
                    $("#note-name").val("");
                    $("#note-description").val("");
                }
            });
        },
        get: function(user_id) {
            $.ajax({
                type: "POST",
                data: { user_id: user_id, action: 'get_notes' },
                url: "php/Note.php",
                success: function(data) {
                    Note.list = jQuery.parseJSON(data);
                    
                    $(".notes_list").empty();
                    $.each(Note.list, function(index, value) {
                        $(".notes_list").append("<li class=\"note\">"+
                            "<div class=\"card\">"+
                                "<div class=\"card-header\">"+value.name+"</div>"+
                                    "<div class=\"card-body clearfix\">"+
                                        "<p class=\"card-text\">"+value.description+"</p>"+
                                        "<button class=\"pull-right btn btn-primary m-1\">"+
                                        "<i data-note_id=\""+ value.id +"\" class=\"fa fa-edit edit_note\"></i>"+
                                        "</button>"+
                                        "<button class=\"pull-right btn btn-primary m-1\">"+
                                        "<i data-note_id=\""+ value.id +"\" class=\"fa fa-trash delete_note\" ></i>"+
                                        "</button>"+
                                    "</div>"+
                                "</div>"+
                            "</li>")
                    });
                }
            })
        },
        delete: function(note_id){
            if(confirm("Are you sure you want to delete this?")){

                $.ajax({
                    type:"POST",
                    data:{id:note_id, action:"delete_note"},
                    url: 'php/Note.php',
                    success:function(data){
                        Note.get(currentUserId);
                    }
                })
            }
        },
        edit_trigger: function($to_edit){
            $("#editNoteModal").modal("show");
            $("#editnote-name").val($to_edit.name);
            $("#editnote-description").val($to_edit.description);
        },
        save_changes: function(){
            if(confirm("Are you sure you want to edit this?")){
                var edited_note = {
                    id:Note.currently_editing,
                    name: $('#editnote-name').val(),
                    description: $('#editnote-description').val(),
                };

                console.log(edited_note);
                $.ajax({
                    type:"POST",
                    data:{data: edited_note, action:"edit_note"},
                    url: 'php/Note.php',
                    success:function(data){
                        Note.get(currentUserId);
                        $("#editNoteModal").modal("hide");
                    }
                });
            }
        }
    };


    $("#add_note").click(function() {
        Note.add($("#note-name").val(),
            $("#note-description").val(),
            currentUserId
            );
    });

    $("#edit_note").click(function() {
        Note.save_changes();
    });

    $(".notes_list").on('click', '.delete_note', function(e) {
        Note.delete(this.dataset.note_id);
    }); 

    $(".notes_list").on('click', '.edit_note', function(e) {
        Note.currently_editing = this.dataset.note_id;
        Note.edit_trigger(Note.list.find(obj=> obj.id === this.dataset.note_id));
        
    });

    ///js for registration
    var Register = {
        add: function(fullname, username, password){
            
            var new_user = {
                fullname: fullname,
                username: username,
                password: password
            };
            $.ajax({
                type: "POST",
                data:{ data: new_user, action: 'register'},
                url: "php/Note.php",
                success:function(data){
                    
                }
            })
        }
    };

    


    $('#register').click(function(){
        if($('#fullname').val()==="" || $('#username').val()==="" || $('#password').val()===""){
            alert('please complete the form');
        }
        else {
            Register.add($('#fullname').val(), $('#username').val(), $('#password').val());
            alert('registered');
            $('#fullname').val(""); 
            $('#username').val(""); 
            $('#password').val("");
        } 
    });

    
    
});