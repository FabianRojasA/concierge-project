package com.jetnews.concierge.api

import android.content.Context
import com.jetnews.concierge.api.login.AuthInterceptor
import okhttp3.OkHttpClient
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory

object ApiAdapter {

    private lateinit var apiService: ApiClient

    val apiClient: ApiClient = Retrofit.Builder()
            .baseUrl("http://127.0.0.1:8000/api/")
            .client(OkHttpClient())
            .addConverterFactory(GsonConverterFactory.create())
            .build()
            .create(ApiClient::class.java)


        private fun okhttpClient(context: Context) : OkHttpClient {
                return OkHttpClient().newBuilder().addInterceptor(AuthInterceptor(context = context)).build()
        }
}