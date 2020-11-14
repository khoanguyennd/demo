//App.js
import MySqlConnection from 'react-native-my-sql-connection';
import React, {Component} from 'react';
import {Platform, StyleSheet, Text,Alert, View,TouchableOpacity,TextInput,Image,Dimensions} from 'react-native';
export default class App extends Component{
  constructor(props){
    super(props);
    this.state={
      username:"",
      password:"",
      checkLogin:0
    }
  }
  _onSubmit=()=>{



//    return fetch('http://10.0.2.2:8888/user/login', {
//      method: 'POST',
//      headers: {
//        'Accept': 'application/json',
//        'Content-Type': 'application/json',
//      },
//      body: JSON.stringify({
//        username: this.state.username,
//        password: this.state.password,
//      })
//    })
//    .then((response) => response.json())
//    .then((responseJson) => {
//        this.setState({checkLogin:responseJson.success});
//        if(this.state.checkLogin>0){
//            //console.warn(responseJson);
//            Alert.alert("Thông báo!","Bạn đã đăng nhập thành công!");
//        }
//        else{
//           // console.warn(responseJson);
//            Alert.alert("Thông báo!","Bạn đã đăng nhập không thành công!");
//        }
//    })
//    .catch((error) =>{
//        console.error(error);
//    });
  }


async function countPlayer() {
  const config = { host:'eli16.cafe24.com',
                     database:'t_bridge',
                     user:'cam',
                     password:'5678',
                     port:3306 ,
                     params:'?zeroDateTimeBehavior=convertToNull'
                     };
               try{
                   const connection = await MySqlConnection.createConnection(config);
                   let res = await connection.executeQuery('SELECT * FROM tb_user');
                   console.log(res);
                   connection.close();
               }catch(err){
                   // handle error
               }
}
  render() {

    this.countPlayer();

    return (
      <View style={styles.container}>
        <Text style={styles.title}>Login React-Native</Text>
        <TextInput placeholder="Username" 
           placeholderTextColor="black"
           underlineColorAndroid="transparent"
           style={styles.txtInput}  onChangeText={(username) => this.setState({username:username})}/>

        <TextInput placeholder="Password"
            underlineColorAndroid="transparent"
            placeholderTextColor="black"
            secureTextEntry={true}
            style={styles.txtInput}  onChangeText={(password) => this.setState({password:password})}/>

        <TouchableOpacity onPress={this._onSubmit} style={styles.btnLogin}>
            <Text style={styles.txtLogin}>Login</Text>
        </TouchableOpacity>
      </View>
    );
  }
}
const DEVICE_WIDTH = Dimensions.get('window').width;
const DEVICE_HEIGHT = Dimensions.get('window').height;

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#F5FCFF',
  },
  title:{
    fontSize:30,
    color:'red'
  },
  txtInput:{
    backgroundColor: 'rgba(0,0,0, 0.1)',
    width: DEVICE_WIDTH - 40,
    
    marginHorizontal: 20,
    padding:8,
    borderRadius: 20,
    color: '#000',
    marginTop:2
  },
  btnLogin:{
     width: DEVICE_WIDTH - 40,
     backgroundColor:'rgba(0,145,234,1)',
     padding:8,
     borderRadius: 20,
     marginTop:2

  },
  txtLogin:{
    color:'#fff',
    textAlign:'center'
  }
 
});