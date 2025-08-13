const Header = ({ userName, logout  }) => {
  return (
    <>
    <div id="user">
      <img src="/assets/user.png" alt="user-icon" />
        <h3>Hello, {userName ? `${userName}` : `User`}</h3>
        <img type="button" onClick={() => logout()} src={userName ? `/assets/user-logout.png`: `/assets/skills.png`} alt="settings" className="settings-icon" />
    </div>
    </>
  )
}

export default Header