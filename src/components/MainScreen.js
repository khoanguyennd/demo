import React, { Component } from 'react';
import { Router, Scene, Actions, ActionConst } from 'react-native-router-flux';

import HomeScreen from './HomeScreen';


export default class MainScreen extends Component {
    static navigationOptions = {
        header: null
    }
  render() {
	  return (
	    <Router hideNavBar={true} options={{headerShown:false}}>
	      <Scene key="root" hideNavBar={true} options={{headerShown:false}}>
	        <Scene key="HomeScreen" component={HomeScreen} animation='fade'
	          hideNavBar={true}
	          navigationOptions
	          options={{headerShown:false}}
	          initial
	        />
	      </Scene>
	    </Router>
	  );
	}
}