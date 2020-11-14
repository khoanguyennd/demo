import React, { Component } from 'react';
import { View, Text, Button, StyleSheet, TouchableOpacity } from 'react-native';
import { Header } from 'react-native-elements';
import { Left, Right, Icon   } from 'native-base';

class HomePage extends Component {
    static navigationOptions = {
        drawerIcon: ({ tintColor }) => (
            <Icon name="home" style={{ fontSize: 24, color: tintColor }} />
        )
    }

    render() {
        return (
            <View style={styles.container}>
                <Header leftComponent={<Icon name="menu" onPress={() => this.props.navigation.openDrawer()} />}/>

                <View style={{ flex: 1, flexDirection: 'column'  }}>

                    <View style= {{ alignItems: 'center', color: '#CCC' , height : 100 , marginTop: 10 }}>
                        <View style={{flex: 1, flexDirection: 'row'}}>
                            <View style={{width: '45%', height: 100, backgroundColor: '#CCC'}} >
                                <Text style={{fontSize: 16, fontWeight: 'bold'}}>N kết quả Số vé chưa sử dụng</Text>
                            </View>
                            <View style={{marginLeft: 10, width: '50%', height: 100, backgroundColor: '#CCC'}} >
                                <Text style={{  justifyContent: 'center', borderColor: '#DB4437', borderWidth: 1,}}>N kết quả Số câu hỏi chưa trả lời
                                </Text>
                            </View>
                        </View>
                    </View>
                    <View style= {{  color: '#CCC', margin : 5 }}>
                          <TouchableOpacity activeOpacity={5.95} style={styles.button} onPress={() => {alert(1)}} >
                              <Text style={styles.text}>Button</Text>
                          </TouchableOpacity>
                    </View>



                </View>


            </View>
        );
    }
}

const styles = StyleSheet.create({
    container: {
            flex: 1
        },
    parent: {
        width: 300,
        height: 500,
        backgroundColor: 'red',
        margin: 50,
    },
    button: {
        flexDirection: 'row',
        height: 50,
        backgroundColor: 'yellow',
        alignItems: 'center',
        justifyContent: 'center',
        marginTop: 50,
        elevation:3,
        borderRadius: 30
    },
    text: {
        fontSize: 16,
        fontWeight: 'bold',
        padding: 100
    }
})
export default HomePage;
