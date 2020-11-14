import { createAppContainer } from 'react-navigation';
import { createStackNavigator } from 'react-navigation-stack';

import LoginScreen from './src/components/LoginScreen';
import HomeScreen from './src/components/HomeScreen';
import MainScreen from './src/components/MainScreen';
//import CreateAccountScreen from './src/components/CreateAccountScreen';

const AppNavigator = createStackNavigator(
  {
    Home: {screen : HomeScreen, navigationOptions: { header: null }},
    Login: {screen : LoginScreen, navigationOptions: { header: null }},
    Main: MainScreen,
    //CreateAccount: CreateAccountScreen,
  },
  {
    initialRouteName: 'Login',
  },
);

export default createAppContainer(AppNavigator);