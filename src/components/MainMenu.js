import React, { PureComponent } from 'react';
import PropTypes from 'prop-types';
import { Link } from 'react-router-dom';
import provider from '../dataProvider';

const dropDownStyles = { cursor: "pointer" };
var dropdownId = 0;

class DropDown extends PureComponent {
    constructor(props) {
        super(props);

        this.menuOnClick = this.menuOnClick.bind(this);
        this.state = {
            id: dropdownId++,
            opened: false
        };
    }

    menuOnClick() {
        this.setState({ opened: !this.state.opened });
    }
  
    render() {
        var links = this.props.items.map(item => <Link to={item.link} className="dropdown-item" key={item.link}>{item.text}</Link>);
        return <li className="nav-item dropdown " onClick={this.menuOnClick}>
            <span className="nav-link dropdown-toggle  " href="#" id={"navbarDropdown" + this.state.id} style={dropDownStyles} role="button" aria-haspopup="true" aria-expanded={this.state.opened}>
                {this.props.text} <span className="caret"></span>
            </span>
            <div className={"dropdown-menu" + (this.state.opened ? " show" : "")} aria-labelledby={"navbarDropdown" + this.state.id}>
                {links}
            </div>
        </li>;
    }
}

DropDown.propTypes = {
    text: PropTypes.string,
    items: PropTypes.arrayOf(PropTypes.shape({
        link: PropTypes.string,
        text: PropTypes.string
    }))
}

export default class MainMenu extends PureComponent {
    leagueDropdown = [
        {text: "O nás", link: "/aboutUs"},
        {text: "Pokuty", link: "/fines"},
    ];

    constructor(props) {
        super(props);
        this.state = {
            opened: false,
            teamMenuList: []   
        };
        this.toggleOnClick = this.toggleOnClick.bind(this);
        this.getMenuTeamsList();
    }

    toggleOnClick() {
        this.setState({ opened: !this.state.opened });
    }

    getMenuTeamsList() {
        provider.getMenuTeamsList().then(data => {
            const teamArray = data.teams.map((el,index) =>{
                return {
                    text : el.name,
                    link : `/${el.short}`
                }
            });            
            this.setState({ teamMenuList : teamArray });
        });
    }

    render() {
        return (
            <nav className="navbar navbar-expand-lg navbar-dark bg-dark">
                <div className="container">
                    <Link to="/" className="navbar-brand">
                        <img src="/images/logo_mini.png" width="77" height="47" alt="KSL.sk logo" />
                    </Link>
                    <button className="navbar-toggler" type="button" onClick={this.toggleOnClick} data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span className="navbar-toggler-icon"></span>
                    </button>

                    <div className={"collapse navbar-collapse" + (this.state.opened ? " show" : "")} id="navbarSupportedContent">
                        <ul className="navbar-nav  w-100 ">
                            <li className="nav-item active "><Link to="/" className="nav-link">Úvod</Link></li>
                            <li className="nav-item "><Link to="/schedule" className="nav-link">Rozpis</Link></li>
                            <li className="nav-item "><Link className="nav-link" to="/tabulka">Tabuľky</Link></li>
                            <DropDown text="Tímy"  items={ this.state.teamMenuList }/>
                            <li className="nav-item "><Link className="nav-link" to="/playground">Ihriská</Link></li>
                            <DropDown text="Liga"  items={ this.leagueDropdown }/>
                            <li className="nav-item ml-lg-auto "><a className="nav-link" href="http://new.ksl.sk/login_facebook.php">Prihlásiť</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        );
    }
}