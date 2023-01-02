var ADD_HCP = false
var EDIT_HCP = false

function loaded () {
  if (!checkedLoggedIn()) {
    $('#N6s45nqg5mKU6vIcDwNvzCizUL9B1lc6').removeClass('hide')
    return
  }
  setMaxDate()
  showDashboardAndGetData()
}

function showDashboardAndGetData () {
  $('#N6s45nqg5mKU6vIcDwNvzCizUL9B1lc6').addClass('hide')
  $('#N6s45nqg5mKU6vIcDwNvzCizUL9B1lc5').removeClass('hide')

  showUserData()
}

function checkedLoggedIn () {
  var googleName = localStorage.getItem('google-name')
  return googleName
}

function logout () {
  // setTimeout(function(){
  localStorage.clear()
  window.location.reload()
  // }, 2000);
}

function deleteHCP () {
  Swal.fire({
    title: 'You sure you want to delete this HCP?',
    showDenyButton: true,
    showCancelButton: true,
    confirmButtonText: 'Yes',
    denyButtonText: `No`
  }).then(async result => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      $('#delete_hcp_form').submit()
    }
  })
}

function logout () {
  // setTimeout(function(){
  localStorage.clear()
  window.location.reload()
  window.location.href = 'index.php'

  // }, 2000);
}

function userSubmit () {
  var email = $('#email').val()
  var password = $('#password').val()

  // Authentication
  var provider = new firebase.auth.GoogleAuthProvider()

  firebase
    .auth()
    .signInWithPopup(provider)
    .then(result => {
      /** @type {firebase.auth.OAuthCredential} */
      var credential = result.credential

      // This gives you a Google Access Token. You can use it to access the Google API.
      var token = credential.accessToken
      // The signed-in user info.
      var user = result.user

      localStorage.setItem('google-signin', true)
      localStorage.setItem('google-name', user.displayName)

      showDashboardAndGetData()

      // ...
    })
    .catch(error => {
      // Handle Errors here.
      var errorCode = error.code
      var errorMessage = error.message
      // The email of the user's account used.
      var email = error.email
      // The firebase.auth.AuthCredential type that was used.
      var credential = error.credential
      // ...

      console.log(error)

      alert(
        'There is an error signin in with Google method, please try again later.'
      )
    })
}

function loaded () {
  if (!checkedLoggedIn()) {
    return (window.location.href = 'index.php')
  }
  showUserData()
}

function checkedLoggedIn () {
  var googleName = localStorage.getItem('google-name')
  return googleName
}

function showDashboardAndGetData () {
  window.location.href = 'home.php?ID=1'

  showUserData()
}

function showUserData () {
  $('.google-name').text(localStorage.getItem('google-name'))
  $('.google-name-avatar').attr(
    'src',
    'https://ui-avatars.com/api/?bold=true&background=0000ff&color=fff&rounded=true&name=' +
      localStorage.getItem('google-name')
  )
}

$('select[data-id="select_hcp_name"').on('change', function (e) {
  var valueSelected = this.value
  window.location.href = 'home.php?ID=' + valueSelected
})
