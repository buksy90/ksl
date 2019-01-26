import React, { Component } from 'react';

export default class MainMenu extends Component {
  render() {
    return (
        <nav className="navbar navbar-expand-lg navbar-dark bg-dark">
            <div className="container">
                <a className="navbar-brand" href="#">
                    <img src="/images/logo_mini.png" width="77" height="47" alt="KSL.sk logo"/>
                </a>
                <button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span className="navbar-toggler-icon"></span>
                </button>

                <div className="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul className="navbar-nav mr-auto">
                        <li className="nav-item active"><a className="nav-link" href="/">Úvod</a></li>
                        <li className="nav-item"><a className="nav-link" href="/rozpis">Rozpis</a></li>
                        <li className="nav-item"><a className="nav-link" href="/tabulka">Tabuľky</a></li>
                        <li className="nav-item"><a className="nav-link" href="/playground">Ihriská</a></li>

                        <li className="nav-item dropdown">
                            <a  className="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Tímy <span className="caret"></span>
                            </a>
                            <div className="dropdown-menu" aria-labelledby="navbarDropdown">
                                /* List of teams */
                            </div>
                        </li>

                        <li className="nav-item navbar-right"><a className="nav-link" href="/login/facebook">Prihlásiť</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    );
  }
}