import React, { PureComponent } from 'react';
import PropTypes from 'prop-types';
import { Link } from 'react-router-dom'

const dropDownStyles = { cursor: "pointer" };
var dropdownId = 0;

class DropDown extends PureComponent {
    constructor(props) {
        super(props);

        this.menuOnClick = this.menuOnClick.bind(this);
        this.state = { 
            id: dropdownId++,
            opened: false,
            links: this.props.items.map(item => <Link to={item.link} className="dropdown-item" key={item.link}>{item.text}</Link>)
         };
    }

    menuOnClick() {
        this.setState({ opened: !this.state.opened });
    }

    render() {
        return  <li className="nav-item dropdown" onClick={this.menuOnClick}>
            <span className="nav-link dropdown-toggle" href="#" id={"navbarDropdown" + this.state.id} style={dropDownStyles} role="button" aria-haspopup="true" aria-expanded={this.state.opened}>
                {this.props.text} <span className="caret"></span>
            </span>
            <div className={"dropdown-menu" + (this.state.opened ? " show" : "")} aria-labelledby={"navbarDropdown" + this.state.id}>
                {this.state.links}
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
    constructor(props) {
        super(props);
        this.state = { opened: false };
        this.toggleOnClick = this.toggleOnClick.bind(this);
    }

    toggleOnClick() {
        this.setState({ opened: !this.state.opened });
    }

    render() {
        return (
            <nav className="navbar navbar-expand-lg navbar-dark bg-dark">
                <div className="container">
                    <Link to="/" className="navbar-brand">
                        <img src="/images/logo_mini.png" width="77" height="47" alt="KSL.sk logo"/>
                    </Link>
                    <button className="navbar-toggler" type="button" onClick={this.toggleOnClick} data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span className="navbar-toggler-icon"></span>
                    </button>

                    <div className={"collapse navbar-collapse" + (this.state.opened ? " show" : "")} id="navbarSupportedContent">
                        <ul className="navbar-nav mr-auto">
                            <li className="nav-item active"><Link to="/" className="nav-link">Úvod</Link></li>
                            <li className="nav-item"><Link to="/schedule" className="nav-link">Rozpis</Link></li>
                            <li className="nav-item"><a className="nav-link" href="/tabulka">Tabuľky</a></li>
                            <li className="nav-item"><a className="nav-link" href="/playground">Ihriská</a></li>
                            <DropDown text="Liga" items={[{text: "Test1", link: "link1"}]}/>
                            <li className="nav-item navbar-right"><a className="nav-link" href="/login/facebook">Prihlásiť</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        );
    }
}