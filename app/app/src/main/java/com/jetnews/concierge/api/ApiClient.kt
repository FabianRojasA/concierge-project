package com.jetnews.concierge.api

import com.jetnews.concierge.api.request.LoginRequest
import com.jetnews.concierge.api.response.LoginResponse
import com.jetnews.concierge.api.response.PersonResponse
import com.jetnews.concierge.api.response.UserResponse
import com.jetnews.concierge.api.response.VisitResponse
import retrofit2.Call
import retrofit2.Response
import retrofit2.http.*

interface ApiClient {

    @GET("personas")
    suspend fun getPersonas(@Header("Authorization") token: String): Response<PersonResponse>

    @POST("login")
    suspend fun login(@Body request: LoginRequest): Response<LoginResponse>

    @GET("registro")
    suspend fun getRegistro(@Header("Authorization") token: String): Response<VisitResponse>
}