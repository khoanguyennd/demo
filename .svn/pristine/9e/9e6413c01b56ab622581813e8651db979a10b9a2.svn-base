import React, { useState } from 'react';
import { ScrollView, View, StyleSheet, TextInput, Button, Text, TouchableOpacity } from 'react-native';
import { Animation } from 'react-native-popup-dialog';
//import FormData from 'FormData';
//import { setToken } from '../api/token';
const LoginScreen = ({ navigation }) => {
//  const [username, onChangeUsername] = useState('');
//  const [password, onChangePassword] = useState('');
  const [onChangeUsername] = useState('');
  const [onChangePassword] = useState('');
  const [username] = useState('orchipro'); // orchipro
  const [password] = useState('123456@a'); // 123456@a
  const [ text] = useState('');
  const [buttonText] = useState('Login');
  const [errorMessage, setErrorMessage] = useState('');
  //const { navigate } = this.props.navigation;

  const submit = () => {
    //onSubmit(email, password)
      fetch('http://tbridge.lavianspa.com/loginApi.html', {
        method: 'POST',
        headers: {
          Accept: 'application/json',
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
                username: username,
                password: password
        }),
      })
     .then((response) => response.json())
     .then((responseJson) => {
        if (responseJson.result) {
            navigation.navigate('Home');
            console.log(responseJson);
            console.log('username: ', username);
            console.log('password: ', password);
        }else{
            alert('Please, input email and password correct!')
        }
     })
     .catch((error) => {
       console.error(error);
     });


//      fetch('https://facebook.github.io/react-native/movies.json', {method: 'GET'})
//      .then((response) => response.json())
//      .then((responseJson) => {
//        console.log('Title:', responseJson.movies[3].title);
//        console.log('releaseYear:', responseJson.movies[3].releaseYear);
//        console.log('id:', responseJson.movies[3].id);
//        if (username == '1' && password == '1') {
//            navigation.navigate('Home');
//        }else {
//            console.log('zo');
//            alert('please, input email and password correct!');
//        }
//      })
//      .catch((error) => {
//        console.error(error);
//      });
  };
// console.log('Email:', username);
// console.log('Password:', password);
  return (
    <ScrollView contentContainerStyle={styles.container}>
        <View style={{width: 300, alignItems: 'center', justifyContent: 'center'}}>
           <Text style={styles.textInfo}>T-Bridge</Text>
           <Text style={styles.textInfo1}>여행 / 티켓 판매자를 위한 통합솔루션</Text>
       </View>
       <TextInput
           style={styles.input}
           onChangeText={(text) => onChangeUsername(text)}
           value={username}
           placeholder="아이디"
       />
        <TextInput
           style={styles.input}
           onChangeText={(text) => onChangePassword(text)}
           value={password}
           placeholder="비밀번호"
           secureTextEntry
        />
         <View style= {{  color: '#CCC', margin : 5 }}>
              <TouchableOpacity activeOpacity={0.95} style={styles.button} onPress={submit} >
                  <Text style={styles.text}>Login</Text>
              </TouchableOpacity>
        </View>
         <View style= {{ alignItems: 'center', color: '#CCC', width: 300, height : 20 , marginTop: 10 }}>
            <View style={{flex: 1, flexDirection: 'row'}}>
                <View style={{width: '75%'}} >
                    <Text style={{fontSize: 10}}>Để tìm ID/PW, vui lòng sử dụng PC version.</Text>
                </View>
                <View style={{ alignItems: 'center', justifyContent: 'center', width: '25%', borderColor: '#DB4437',  borderWidth: 1, borderRadius: 5}} >
                    <Text style={{fontSize: 10,  color: '#DB4437'}}>PC version</Text>
                </View>
            </View>
        </View>
    </ScrollView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
  },
  input: {
    height: 40,
    width: 300,
    borderColor: '#CCC',
    borderWidth: 1,
    marginTop: 20,
    padding: 2,
    borderBottomColor: "#CCC",
    //borderBottomWidth: StyleSheet.hairlineWidth,
    borderStyle:  'dashed'
  },
  textInfo: {
     fontSize: 30,
     backgroundColor: 'transparent',
     borderRadius: 50,
     fontWeight: 'bold'
  },
  textInfo1: {
     fontSize: 16,
     backgroundColor: 'transparent',
     paddingBottom: 10,
     borderRadius: 50,
  },
  buttonLogin: {
    width: 300,
    height: 100,
    //padding: 20,
    //borderWidth: 300,
    color: 'red',
    fontSize: 160,
    //backgroundColor: 'transparent',
    alignItems: 'center',
    //justifyContent: 'center',
    backgroundColor: '#F035E0',
    borderRadius: 20,
    zIndex: 100,
  },
  login_content: {
      width: 500,
      borderColor: '#CCC',
      borderRadius: 8,
      backgroundColor: '#FFF',
  },
  login_head: {
      borderWidth: 1,
      //borderStyle: 'solid',
      borderColor: '#DB4437',
      padding: 15,
      backgroundColor: '#DB4437',
      borderTopLeftRadius: 8,
      borderTopRightRadius: 8,
      color: '#FFF',
      alignItems: 'center',
      lineHeight: 30,
  },
  parent: {
          width: 300,
          height: 500,
          backgroundColor: 'red',
          margin: 50,
  },
  button: {
      flexDirection: 'row',
      width: 300,
      height: 40,
      backgroundColor: '#DB4437',
      alignItems: 'center',
      justifyContent: 'center',
      marginTop: 12,
      elevation:3,
      borderRadius: 5
  },
  text: {
      fontSize: 14,
      fontWeight: 'bold',
      color: '#fff'
  }
});

export default LoginScreen;